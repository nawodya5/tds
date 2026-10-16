<?php

namespace App\Http\Controllers;



use App\Models\CalendarEvent;
use App\Models\ClassModel;
use App\Models\ClassSession;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $month = $today->month;
        $year = $today->year;

        // Main summary figures
        $totalStudents = Student::where('status', true)->count();

        $totalClasses = ClassModel::where('status', true)->count();

        $todaySessions = ClassSession::query()
            ->with(['classroom.location'])
            ->whereDate('session_date', $today)
            ->where('status', '!=', 'Cancelled')
            ->orderBy('start_time')
            ->get();

        $todaySessionIds = $todaySessions->pluck('id');

        $todayAttendance = DB::table('attendances')
            ->whereIn('class_session_id', $todaySessionIds)
            ->whereNull('deleted_at')
            ->selectRaw("
                COUNT(*) as total_marked,
                SUM(CASE WHEN attendance_status = 'Present' THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN attendance_status = 'Absent' THEN 1 ELSE 0 END) as absent_count,
                SUM(CASE WHEN attendance_status = 'Late' THEN 1 ELSE 0 END) as late_count
            ")
            ->first();

        $presentCount = (int) ($todayAttendance->present_count ?? 0);
        $absentCount = (int) ($todayAttendance->absent_count ?? 0);
        $lateCount = (int) ($todayAttendance->late_count ?? 0);
        $markedCount = (int) ($todayAttendance->total_marked ?? 0);

        $attendanceRate = $markedCount > 0
            ? round((($presentCount + $lateCount) / $markedCount) * 100)
            : 0;

        // Current month's payment collection
        $monthlyCollection = DB::table('student_payments')
            ->where('payment_month', $month)
            ->where('payment_year', $year)
            ->where('payment_status', 'Paid')
            ->whereNull('deleted_at')
            ->sum('paid_amount');

        // Active registrations without a paid payment record this month
        $unpaidRegistrations = DB::table('student_class_registrations as scr')
            ->join('students as s', 's.id', '=', 'scr.student_id')
            ->join('classes as c', 'c.id', '=', 'scr.class_id')
            ->leftJoin('student_payments as sp', function ($join) use ($month, $year) {
                $join->on('sp.student_id', '=', 'scr.student_id')
                    ->on('sp.class_id', '=', 'scr.class_id')
                    ->where('sp.payment_month', '=', $month)
                    ->where('sp.payment_year', '=', $year)
                    ->whereNull('sp.deleted_at')
                    ->where('sp.payment_status', '=', 'Paid');
            })
            ->whereNull('scr.deleted_at')
            ->whereNull('s.deleted_at')
            ->whereNull('c.deleted_at')
            ->where('scr.status', true)
            ->where('s.status', true)
            ->where('c.status', true)
            ->whereNull('sp.id')
            ->count();

        // Attendance chart for the last six months
        $chartStart = $today->copy()->subMonths(5)->startOfMonth();
        $chartEnd = $today->copy()->endOfMonth();

        $monthlyAttendanceRows = DB::table('attendances as a')
            ->join('class_sessions as cs', 'cs.id', '=', 'a.class_session_id')
            ->whereNull('a.deleted_at')
            ->whereNull('cs.deleted_at')
            ->whereBetween('cs.session_date', [
                $chartStart->toDateString(),
                $chartEnd->toDateString(),
            ])
            ->where('cs.status', '!=', 'Cancelled')
            ->selectRaw("
                YEAR(cs.session_date) as attendance_year,
                MONTH(cs.session_date) as attendance_month,
                SUM(CASE WHEN a.attendance_status = 'Present' THEN 1 ELSE 0 END) as present_count,
                SUM(CASE WHEN a.attendance_status = 'Absent' THEN 1 ELSE 0 END) as absent_count,
                SUM(CASE WHEN a.attendance_status = 'Late' THEN 1 ELSE 0 END) as late_count
            ")
            ->groupByRaw('YEAR(cs.session_date), MONTH(cs.session_date)')
            ->get()
            ->keyBy(fn ($row) => $row->attendance_year . '-' . $row->attendance_month);

        $attendanceChart = collect(range(0, 5))->map(function ($offset) use ($chartStart, $monthlyAttendanceRows) {
            $date = $chartStart->copy()->addMonths($offset);
            $key = $date->year . '-' . $date->month;
            $row = $monthlyAttendanceRows->get($key);

            return [
                'label' => $date->format('M'),
                'present' => (int) ($row->present_count ?? 0),
                'absent' => (int) ($row->absent_count ?? 0),
                'late' => (int) ($row->late_count ?? 0),
            ];
        })->values();

        // Current month's payment chart
        $paymentChart = collect(range(1, $month))->map(function ($paymentMonth) use ($year) {
            $total = DB::table('student_payments')
                ->where('payment_month', $paymentMonth)
                ->where('payment_year', $year)
                ->where('payment_status', 'Paid')
                ->whereNull('deleted_at')
                ->sum('paid_amount');

            return [
                'label' => Carbon::create($year, $paymentMonth, 1)->format('M'),
                'amount' => (float) $total,
            ];
        })->values();

        // Upcoming class sessions
        $upcomingSessions = ClassSession::query()
            ->with(['classroom.location'])
            ->whereDate('session_date', '>=', $today)
            ->where('status', 'Upcoming')
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        // Upcoming active calendar events
        $upcomingEvents = CalendarEvent::query()
            ->where('status', true)
            ->whereDate('event_date', '>=', $today)
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'today',
            'totalStudents',
            'totalClasses',
            'todaySessions',
            'presentCount',
            'absentCount',
            'lateCount',
            'markedCount',
            'attendanceRate',
            'monthlyCollection',
            'unpaidRegistrations',
            'attendanceChart',
            'paymentChart',
            'upcomingSessions',
            'upcomingEvents'
        ));
    }
}



