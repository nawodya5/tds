<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Student;
use App\Models\StudentClassRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with([
            'registrations' => function ($query) {
                $query->where('status', true)
                    ->with('classroom.location');
            }
        ])->latest()->get();

        $classes = ClassModel::where('status', true)
            ->orderBy('name')
            ->get();

        $activeStudents = Student::where('status', true)->count();

        $inactiveStudents = Student::where('status', false)->count();

        $newStudentsThisMonth = Student::whereMonth(
            'created_at',
            now()->month
        )->whereYear(
            'created_at',
            now()->year
        )->count();

        return view('students', compact(
            'students',
            'classes',
            'activeStudents',
            'inactiveStudents',
            'newStudentsThisMonth'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'student_contact_number' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'class_id' => [
                'required',
                'integer',
                Rule::exists('classes', 'id')->where('status', true),
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $student = Student::create([
                'registration_number' => null,
                'name' => $validated['name'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'student_contact_number' => $validated['student_contact_number'],
                'address' => $validated['address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => true,
            ]);

            StudentClassRegistration::create([
                'student_id' => $student->id,
                'class_id' => $validated['class_id'],
                'is_primary_class' => true,
                'registration_date' => now()->toDateString(),
                'status' => true,
            ]);

            $student->update([
                'registration_number' => '000' . $student->id,
            ]);
        });

        return redirect()
            ->route('students.index')
            ->with('success', 'Student registered successfully.');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'student_contact_number' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'class_id' => [
                'required',
                'integer',
                Rule::exists('classes', 'id')->where('status', true),
            ],
            'status' => ['required', 'boolean'],
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->update([
                'name' => $validated['name'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'student_contact_number' => $validated['student_contact_number'],
                'address' => $validated['address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => $validated['status'],
            ]);

            $registrations = StudentClassRegistration::where(
                'student_id',
                $student->id
            )->where('is_primary_class', true);

            $primaryRegistration = (clone $registrations)->first();

            if (
                $primaryRegistration &&
                (int) $primaryRegistration->class_id !== (int) $validated['class_id']
            ) {
                $primaryRegistration->update([
                    'is_primary_class' => false,
                ]);

                StudentClassRegistration::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'class_id' => $validated['class_id'],
                    ],
                    [
                        'is_primary_class' => true,
                        'registration_date' => now()->toDateString(),
                        'status' => true,
                    ]
                );
            } elseif (! $primaryRegistration) {
                StudentClassRegistration::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'class_id' => $validated['class_id'],
                    ],
                    [
                        'is_primary_class' => true,
                        'registration_date' => now()->toDateString(),
                        'status' => true,
                    ]
                );
            }
        });

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
