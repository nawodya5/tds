<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\ClassSession;
use App\Models\Student;
use App\Models\StudentClassRegistration;
use App\Models\StudentPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    public function index()
    {
        $classes = ClassModel::query()
            ->where('status', true)
            ->with('location')
            ->orderBy('name')
            ->get();

        return view('attendance', compact('classes'));
    }

    public function sessions(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'month' => ['nullable', 'integer', 'between:1,12'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
        ]);

        $class = ClassModel::query()->with('location')->findOrFail($validated['class_id']);
        $today = now()->toDateString();
        $month = (int) ($validated['month'] ?? now()->format('m'));
        $year = (int) ($validated['year'] ?? now()->format('Y'));

        $monthlySessions = ClassSession::query()
            ->where('class_id', $class->id)
            ->whereYear('session_date', $year)
            ->whereMonth('session_date', $month)
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->get();

        $todaySession = ClassSession::query()
            ->where('class_id', $class->id)
            ->whereDate('session_date', $today)
            ->where('status', 'Upcoming')
            ->whereTime('end_time', '>=', now()->format('H:i:s'))
            ->orderBy('start_time')
            ->first();

        $futureSession = ClassSession::query()
            ->where('class_id', $class->id)
            ->where('status', 'Upcoming')
            ->where(function ($query) use ($today) {
                $query->whereDate('session_date', '>', $today)
                    ->orWhere(function ($query) use ($today) {
                        $query->whereDate('session_date', $today)
                            ->whereTime('start_time', '>', now()->format('H:i:s'));
                    });
            })
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->first();

        $selectedSession = $todaySession ?? $futureSession;

        if (!$selectedSession) {
            $selectedSession = ClassSession::query()
                ->where('class_id', $class->id)
                ->whereDate('session_date', $today)
                ->orderBy('start_time')
                ->first();
        }

        return response()->json([
            'class' => $class,
            'sessions' => $monthlySessions,
            'selected_session' => $selectedSession,
        ]);
    }

    public function students(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'session_id' => ['nullable', 'integer', 'exists:class_sessions,id'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $classId = (int) $validated['class_id'];
        $session = null;

        if (!empty($validated['session_id'])) {
            $session = ClassSession::query()
                ->where('class_id', $classId)
                ->findOrFail($validated['session_id']);
        }

        $registrationsQuery = StudentClassRegistration::query()
            ->where('class_id', $classId)
            ->where('status', true)
            ->whereHas('student', fn($query) => $query->where('status', true))
            ->with('student');

        if (!empty($validated['search'])) {
            $search = trim($validated['search']);
            $registrationsQuery->whereHas('student', function ($query) use ($search) {
                $query->where(function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('registration_number', 'like', "%{$search}%");
                });
            });
        }

        $registrations = $registrationsQuery->orderBy('id')->get();
        $studentIds = $registrations->pluck('student_id');
        $month = (int) now()->format('m');
        $year = (int) now()->format('Y');

        $unpaidIds = StudentPayment::query()
            ->where('class_id', $classId)
            ->where('payment_month', $month)
            ->where('payment_year', $year)
            ->where('payment_status', 'Unpaid')
            ->whereIn('student_id', $studentIds)
            ->pluck('student_id')
            ->unique();

        $attendanceMap = collect();

        if ($session) {
            $attendanceMap = Attendance::query()
                ->where('class_session_id', $session->id)
                ->whereIn('student_id', $studentIds)
                ->get()
                ->keyBy('student_id');
        }

        $students = $registrations->map(function ($registration) use ($unpaidIds, $attendanceMap) {
            $student = $registration->student;
            $attendance = $attendanceMap->get($student->id);
            $isUnpaid = $unpaidIds->contains($student->id);

            return [
                'id' => $student->id,
                'name' => $student->name,
                'registration_number' => $student->registration_number,
                'student_contact_number' => $student->student_contact_number,
                'attendance_status' => $attendance?->attendance_status,
                'attendance_marked' => $attendance !== null,
                'marked_at' => $attendance?->marked_at,
                'is_paid_this_month' => !$isUnpaid,
                'payment_status' => $isUnpaid ? 'Unpaid' : 'Paid',
            ];
        })->values();

        return response()->json([
            'data' => $students,
            'summary' => [
                'total_students' => $registrations->count(),
                'unpaid_students' => $unpaidIds->count(),
                'absent_students' => $students->where('attendance_status', 'Absent')->count(),
                'unmarked_students' => $students->where('attendance_marked', false)->count(),
            ],
            'session' => $session,
        ]);
    }

    public function studentMonthlyDetails(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'session_id' => ['required', 'integer', 'exists:class_sessions,id'],
        ]);

        $studentId = (int) $validated['student_id'];
        $classId = (int) $validated['class_id'];

        $session = ClassSession::query()
            ->where('class_id', $classId)
            ->findOrFail($validated['session_id']);

        $registered = StudentClassRegistration::query()
            ->where('student_id', $studentId)
            ->where('class_id', $classId)
            ->where('status', true)
            ->exists();

        if (!$registered) {
            throw ValidationException::withMessages([
                'student_id' => 'This student is not actively registered in the selected class.',
            ]);
        }

        $month = (int) $session->session_date->format('m');
        $year = (int) $session->session_date->format('Y');

        $sessions = ClassSession::query()
            ->where('class_id', $classId)
            ->whereYear('session_date', $year)
            ->whereMonth('session_date', $month)
            ->with(['attendances' => fn($query) => $query->where('student_id', $studentId)])
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->get()
            ->map(function ($item) {
                $attendance = $item->attendances->first();

                return [
                    'id' => $item->id,
                    'session_date' => $item->session_date->toDateString(),
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'status' => $item->status,
                    'attendance_status' => $attendance?->attendance_status,
                    'attendance_marked' => $attendance !== null,
                ];
            });

        $payment = StudentPayment::withTrashed()
            ->where('student_id', $studentId)
            ->where('class_id', $classId)
            ->where('payment_month', $month)
            ->where('payment_year', $year)
            ->first();

        return response()->json([
            'student' => Student::query()->findOrFail($studentId),
            'class' => ClassModel::query()->with('location')->findOrFail($classId),
            'selected_session' => $session,
            'month' => $month,
            'year' => $year,
            'sessions' => $sessions,
            'payment' => [
                'id' => $payment?->id,
                'payment_status' => $payment && !$payment->trashed() ? $payment->payment_status : 'Unpaid',
                'paid_amount' => $payment?->paid_amount ?? 0,
                'payment_date' => $payment?->payment_date?->toDateString(),
            ],
        ]);
    }

    public function save(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'class_id' => ['required', 'integer', 'exists:classes,id'],
            'session_id' => ['required', 'integer', 'exists:class_sessions,id'],
            'attendance_status' => ['required', Rule::in(['Present', 'Absent'])],
            'fee_paid' => ['required', 'boolean'],
        ]);

        $markedBy = Auth::id();

        if (!$markedBy) {
            return response()->json(['message' => 'You must be logged in to mark attendance.'], 401);
        }

        $result = DB::transaction(function () use ($validated, $markedBy) {
            $studentId = (int) $validated['student_id'];
            $classId = (int) $validated['class_id'];
            $sessionId = (int) $validated['session_id'];

            $session = ClassSession::query()
                ->where('class_id', $classId)
                ->lockForUpdate()
                ->findOrFail($sessionId);

            if (!$session->session_date->isToday()) {
                throw ValidationException::withMessages([
                    'session_id' => 'Attendance can only be marked for a session scheduled for today.',
                ]);
            }

            if ($session->status !== 'Upcoming') {
                throw ValidationException::withMessages([
                    'session_id' => 'Only an upcoming session scheduled for today can be marked.',
                ]);
            }

            $registered = StudentClassRegistration::query()
                ->where('student_id', $studentId)
                ->where('class_id', $classId)
                ->where('status', true)
                ->exists();

            if (!$registered) {
                throw ValidationException::withMessages([
                    'student_id' => 'This student is not actively registered in the selected class.',
                ]);
            }

            $student = Student::query()->findOrFail($studentId);
            $class = ClassModel::query()->findOrFail($classId);

            $attendance = Attendance::withTrashed()
                ->where('class_session_id', $sessionId)
                ->where('student_id', $studentId)
                ->first();

            $attendanceData = [
                'marked_by' => $markedBy,
                'attendance_status' => $validated['attendance_status'],
                'marked_at' => now(),
            ];

            if ($attendance) {
                if ($attendance->trashed()) {
                    $attendance->restore();
                }
                $attendance->update($attendanceData);
            } else {
                $attendance = Attendance::create(array_merge($attendanceData, [
                    'class_session_id' => $sessionId,
                    'student_id' => $studentId,
                ]));
            }

            $month = (int) $session->session_date->format('m');
            $year = (int) $session->session_date->format('Y');

            $payment = StudentPayment::withTrashed()
                ->where('student_id', $studentId)
                ->where('class_id', $classId)
                ->where('payment_month', $month)
                ->where('payment_year', $year)
                ->lockForUpdate()
                ->first();

            $isPaid = (bool) $validated['fee_paid'];
            $paymentData = [
                'monthly_fee' => $class->monthly_fee,
                'paid_amount' => $isPaid ? $class->monthly_fee : 0,
                'payment_date' => $isPaid ? now()->toDateString() : null,
                'payment_status' => $isPaid ? 'Paid' : 'Unpaid',
            ];

            if ($payment) {
                if ($payment->trashed()) {
                    $payment->restore();
                }
                $payment->update($paymentData);
            } else {
                $payment = StudentPayment::create(array_merge($paymentData, [
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'payment_month' => $month,
                    'payment_year' => $year,
                ]));
            }

            return [
                'attendance' => $attendance->fresh(),
                'payment' => $payment->fresh(),
            ];
        });

        return response()->json([
            'message' => 'Attendance and monthly payment status saved successfully.',
            'data' => $result,
        ]);
    }
}
