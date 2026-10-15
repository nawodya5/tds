<?php

namespace App\Services;

use App\Models\ClassModel;
use App\Models\ClassSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClassSessionGeneratorService
{
    public function generateForClass(
        ClassModel $class,
        ?Carbon $startDate = null,
        ?Carbon $endDate = null
    ): int {
        if (!$class->status) {
            return 0;
        }

        $startDate = ($startDate ?? today())->copy()->startOfDay();
        $endDate = ($endDate ?? $startDate->copy()->addMonthsNoOverflow(3))
            ->copy()
            ->startOfDay();

        $class->loadMissing('days');

        $daysOfWeek = $class->days
            ->pluck('day_of_week')
            ->map(fn($day) => (int) $day)
            ->unique()
            ->values()
            ->all();

        if (empty($daysOfWeek)) {
            return 0;
        }

        $created = 0;

        DB::transaction(function () use (
            $class,
            $startDate,
            $endDate,
            $daysOfWeek,
            &$created
        ) {
            for (
                $date = $startDate->copy();
                $date->lte($endDate);
                $date->addDay()
            ) {
                // Carbon uses ISO weekdays: Monday = 1, Sunday = 7.
                if (!in_array($date->dayOfWeekIso, $daysOfWeek, true)) {
                    continue;
                }

                $session = ClassSession::firstOrCreate(
                    [
                        'class_id' => $class->id,
                        'session_date' => $date->toDateString(),
                    ],
                    [
                        'start_time' => $class->start_time,
                        'end_time' => $class->end_time,
                        'status' => 'Upcoming',
                    ]
                );

                if ($session->wasRecentlyCreated) {
                    $created++;
                }
            }
        });

        return $created;
    }

    public function generateForActiveClasses(): int
    {
        $created = 0;

        ClassModel::query()
            ->where('status', true)
            ->with('days')
            ->chunkById(100, function ($classes) use (&$created) {
                foreach ($classes as $class) {
                    $created += $this->generateForClass($class);
                }
            });

        return $created;
    }




    public function reconcileForClass(ClassModel $class): void
    {
        $class->load('days');

        $today = today()->startOfDay();
        $endDate = $today->copy()->addMonthsNoOverflow(3);

        $daysOfWeek = $class->days
            ->pluck('day_of_week')
            ->map(fn($day) => (int) $day)
            ->unique()
            ->values()
            ->all();

        // Cancel future upcoming sessions when the class is inactive.
        if (!$class->status) {
            ClassSession::where('class_id', $class->id)
                ->where('status', 'Upcoming')
                ->whereDate('session_date', '>=', $today->toDateString())
                ->update([
                    'status' => 'Cancelled',
                ]);

            return;
        }

        // Restore cancelled sessions that match the active class schedule.
        // Past sessions become Completed; today and future sessions become Upcoming.
        $cancelledSessions = ClassSession::where('class_id', $class->id)
            ->where('status', 'Cancelled')
            ->whereDate('session_date', '<=', $endDate->toDateString())
            ->get();

        foreach ($cancelledSessions as $session) {
            $sessionDate = Carbon::parse($session->session_date);

            if (!in_array($sessionDate->dayOfWeekIso, $daysOfWeek, true)) {
                continue;
            }

            $session->update([
                'status' => $sessionDate->lt($today) ? 'Completed' : 'Upcoming',
                'start_time' => $class->start_time,
                'end_time' => $class->end_time,
            ]);
        }

        // Reconcile existing upcoming sessions with the current schedule.
        $sessions = ClassSession::where('class_id', $class->id)
            ->where('status', 'Upcoming')
            ->whereDate('session_date', '>=', $today->toDateString())
            ->whereDate('session_date', '<=', $endDate->toDateString())
            ->get();

        foreach ($sessions as $session) {
            $sessionDate = Carbon::parse($session->session_date);

            $matchesSchedule = in_array(
                $sessionDate->dayOfWeekIso,
                $daysOfWeek,
                true
            );

            $hasAttendance = $session->attendances()->exists();

            if (!$matchesSchedule) {
                if (!$hasAttendance) {
                    $session->update([
                        'status' => 'Cancelled',
                    ]);
                }

                continue;
            }

            $session->update([
                'start_time' => $class->start_time,
                'end_time' => $class->end_time,
            ]);
        }

        // Generate any missing sessions without duplicating existing records.
        $this->generateForClass($class, $today, $endDate);
    }
}
