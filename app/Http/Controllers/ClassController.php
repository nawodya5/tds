<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Location;
use App\Services\ClassSessionGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class ClassController extends Controller
{
    // Display classes
    public function index()
    {
        $classes = ClassModel::with(['location', 'days'])
            ->latest()
            ->get();
            // ->paginate(10);

        $locations = Location::where('status', true)
            ->orderBy('name')
            ->get();

        return view('classes', compact('classes', 'locations'));
    }

    // Store a class
    public function store(Request $request, ClassSessionGeneratorService $sessionGenerator)
    {
        $validated = $request->validate([
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'name' => ['required', 'string', 'max:255'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'status' => ['required', 'boolean'],
            'days' => ['required', 'array', 'min:1'],
            'days.*' => ['required', 'integer', 'between:1,7', 'distinct'],
        ]);

        $validated['status'] = $request->boolean('status', true);

        try {
            DB::transaction(function () use ($validated, $sessionGenerator) {
                $class = ClassModel::create([
                    'location_id' => $validated['location_id'],
                    'name' => $validated['name'],
                    'monthly_fee' => $validated['monthly_fee'],
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'status' => $validated['status'],
                ]);

                $class->days()->createMany(
                    collect($validated['days'])
                        ->map(fn($day) => [
                            'day_of_week' => (int) $day,
                        ])
                        ->all()
                );

                $sessionGenerator->generateForClass($class);
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Class created successfully.',
                ], 201);
            }

            return redirect()
                ->route('classes')
                ->with('success', 'Class created successfully.');
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            Log::error('Class creation failed.', [
                'message' => $exception->getMessage(),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unable to save the class. Please check the submitted data and try again.',
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Unable to save the class. Please check the submitted data and try again.');
        }
    }

    // Update a class
    public function update(Request $request, ClassModel $class, ClassSessionGeneratorService $sessionGenerator)
    {
        $validated = $request->validate([
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'name' => ['required', 'string', 'max:255'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'status' => ['sometimes', 'boolean'],
            'days' => ['required', 'array', 'min:1'],
            'days.*' => [
                'required',
                'integer',
                'between:1,7',
                'distinct',
            ],
        ]);

        $validated['status'] = $request->boolean('status', true);

        DB::transaction(function () use (
            $validated,
            $class,
            $sessionGenerator
        ) {
            $class->update([
                'location_id' => $validated['location_id'],
                'name' => $validated['name'],
                'monthly_fee' => $validated['monthly_fee'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => $validated['status'],
            ]);

            // Replace the recurring weekday configuration.
            $class->days()->delete();

            $class->days()->createMany(
                collect($validated['days'])
                    ->map(fn($day) => [
                        'day_of_week' => (int) $day,
                    ])
                    ->all()
            );

            // Reconcile future sessions with the updated schedule.
            $sessionGenerator->reconcileForClass($class->fresh());
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Class updated successfully.',
            ]);
        }

        return redirect()
            ->route('classes')
            ->with('success', 'Class updated successfully.');
    }

    // Soft delete a class
    public function destroy(ClassModel $class)
    {
        $class->delete();

        return redirect()
            ->route('classes')
            ->with('success', 'Class deleted successfully.');
    }
}
