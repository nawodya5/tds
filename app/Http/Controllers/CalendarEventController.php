<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use App\Models\ClassSession;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CalendarEventController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function data(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'month' => ['required', 'date_format:Y-m'],
        ]);

        $month = Carbon::createFromFormat('Y-m', $validated['month']);
        $from = $month->copy()->startOfMonth()->toDateString();
        $to = $month->copy()->endOfMonth()->toDateString();

        $events = CalendarEvent::query()
            ->where('status', true)
            ->whereBetween('event_date', [$from, $to])
            ->get()
            ->map(fn (CalendarEvent $event) => [
                'id' => 'event-' . $event->id,
                'event_id' => $event->id,
                'date' => $event->event_date->format('Y-m-d'),
                'title' => $event->title,
                'type' => strtolower($event->event_type),
                'start_time' => $event->start_time,
                'end_time' => $event->end_time,
                'description' => $event->description,
                'location' => null,
                'status' => 'Active',
            ]);

        $sessions = ClassSession::query()
            ->with(['classroom.location'])
            ->whereBetween('session_date', [$from, $to])
            ->get()
            ->map(fn (ClassSession $session) => [
                'id' => 'class-' . $session->id,
                'session_id' => $session->id,
                'date' => $session->session_date->format('Y-m-d'),
                'title' => $session->classroom?->name ?? 'Class session',
                'type' => 'class',
                'start_time' => $session->start_time,
                'end_time' => $session->end_time,
                'description' => $session->status === 'Cancelled' ? 'Cancelled session' : 'Regular class session',
                'location' => $session->classroom?->location?->name,
                'status' => $session->status,
            ]);

        return response()->json([
            'events' => $events->concat($sessions)->values(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event_type' => ['required', Rule::in(['Workshop', 'Event', 'Holiday'])],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i', 'after:start_time'],
            'description' => ['nullable', 'string'],
            'conflict_action' => ['nullable', Rule::in(['cancel', 'add_without_cancel'])],
        ]);

        $isHoliday = $validated['event_type'] === 'Holiday';

        if (!$isHoliday && (empty($validated['start_time']) || empty($validated['end_time']))) {
            return response()->json([
                'message' => 'Please provide both a start time and an end time.',
                'errors' => [
                    'start_time' => ['A start time is required.'],
                    'end_time' => ['An end time is required.'],
                ],
            ], 422);
        }

        if ($isHoliday) {
            $validated['start_time'] = null;
            $validated['end_time'] = null;
        }

        $conflictsQuery = ClassSession::query()
            ->with(['classroom.location'])
            ->whereDate('session_date', $validated['event_date'])
            ->where('status', 'Upcoming');

        if (!$isHoliday) {
            $conflictsQuery
                ->where('start_time', '<', $validated['end_time'])
                ->where('end_time', '>', $validated['start_time']);
        }

        $conflicts = $conflictsQuery->get();
        $action = $validated['conflict_action'] ?? null;

        if ($conflicts->isNotEmpty() && !$action) {
            return response()->json([
                'requires_confirmation' => true,
                'is_holiday' => $isHoliday,
                'message' => $isHoliday
                    ? 'Class sessions are scheduled on this date. Do you want to cancel them and add the holiday?'
                    : 'The selected time overlaps with one or more class sessions. Choose how to continue.',
                'conflicts' => $conflicts->map(fn (ClassSession $session) => [
                    'id' => $session->id,
                    'class_name' => $session->classroom?->name ?? 'Unknown class',
                    'location' => $session->classroom?->location?->name,
                    'date' => $session->session_date->format('Y-m-d'),
                    'start_time' => $session->start_time,
                    'end_time' => $session->end_time,
                ])->values(),
            ], 409);
        }

        if ($conflicts->isNotEmpty() && $action === 'add_without_cancel') {
            if ($isHoliday) {
                return response()->json([
                    'message' => 'A holiday cannot be added while leaving scheduled sessions active. Cancel the sessions or exit.',
                ], 422);
            }

            return response()->json([
                'saved' => true,
                'event' => $this->createEvent($validated),
                'message' => 'Event added. Conflicting class sessions were not changed.',
            ], 201);
        }

        // if ($conflicts->isNotEmpty() && $action === 'cancel') {
        //     $sessionsWithAttendance = $conflicts->filter(
        //         fn (ClassSession $session) => Attendance::query()
        //             ->where('class_session_id', $session->id)
        //             ->exists()
        //     );

        //     if ($sessionsWithAttendance->isNotEmpty()) {
        //         return response()->json([
        //             'message' => 'Some conflicting sessions already have attendance records and cannot be cancelled. No changes were saved.',
        //             'sessions' => $sessionsWithAttendance->map(fn (ClassSession $session) => [
        //                 'class_name' => $session->classroom?->name ?? 'Unknown class',
        //                 'date' => $session->session_date->format('Y-m-d'),
        //             ])->values(),
        //         ], 422);
        //     }
        // }

        $event = DB::transaction(function () use ($validated, $conflicts, $action) {
            if ($conflicts->isNotEmpty() && $action === 'cancel') {
                foreach ($conflicts as $session) {
                    $session->update(['status' => 'Cancelled']);
                }
            }

            return $this->createEvent($validated);
        });

        return response()->json([
            'saved' => true,
            'event' => $event,
            'message' => $conflicts->isNotEmpty() && $action === 'cancel'
                ? 'Event saved and conflicting class sessions cancelled.'
                : 'Event saved successfully.',
        ], 201);
    }

    private function createEvent(array $validated): CalendarEvent
    {
        return CalendarEvent::create([
            'title' => $validated['title'],
            'event_type' => $validated['event_type'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => true,
        ]);
    }
}
