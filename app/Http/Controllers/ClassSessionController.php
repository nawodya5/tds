<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSession;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ClassSessionController extends Controller
{
    public function index()
    {
        $classes = ClassModel::with('location')
            ->orderBy('name')
            ->get();

        $locations = Location::orderBy('name')->get();

        return view('class_sessions', compact(
            'classes',
            'locations'
        ));
    }

    public function data(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'class_id' => ['nullable', 'integer', 'exists:classes,id'],
            'location_id' => ['nullable', 'integer', 'exists:locations,id'],
            'status' => [
                'nullable',
                Rule::in(['Upcoming', 'Completed', 'Cancelled']),
            ],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'per_page' => ['nullable', 'integer', 'min:5', 'max:100'],
        ]);

        $query = ClassSession::query()
            ->with(['classroom.location'])
            ->withCount('attendances');

        if (!empty($validated['search'])) {
            $search = $validated['search'];

            $query->whereHas('classroom', function ($classQuery) use ($search) {
                $classQuery->where('name', 'like', "%{$search}%");
            });
        }

        if (!empty($validated['class_id'])) {
            $query->where('class_id', $validated['class_id']);
        }

        if (!empty($validated['location_id'])) {
            $query->whereHas('classroom', function ($classQuery) use ($validated) {
                $classQuery->where('location_id', $validated['location_id']);
            });
        }

        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (!empty($validated['date_from'])) {
            $query->whereDate('session_date', '>=', $validated['date_from']);
        }

        if (!empty($validated['date_to'])) {
            $query->whereDate('session_date', '<=', $validated['date_to']);
        }

        $sessions = $query
            ->orderByDesc('session_date')
            ->orderBy('start_time')
            ->paginate($validated['per_page'] ?? 10);

        return response()->json($sessions);
    }

    public function cancel(Request $request, ClassSession $classSession): JsonResponse
    {
        $validated = $request->validate([
            'cancellation_reason' => ['required', 'string', 'max:2000'],
        ]);

        $result = DB::transaction(function () use ($classSession, $validated) {
            $session = ClassSession::query()
                ->whereKey($classSession->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($session->status !== 'Upcoming') {
                throw ValidationException::withMessages([
                    'session' => 'Only upcoming sessions can be cancelled.',
                ]);
            }

            if ($session->attendances()->exists()) {
                throw ValidationException::withMessages([
                    'session' => 'This session has attendance records and cannot be cancelled.',
                ]);
            }

            $session->update([
                'status' => 'Cancelled',
                'cancellation_reason' => $validated['cancellation_reason'],
            ]);

            return $session;
        });

        return response()->json([
            'message' => 'Class session cancelled successfully.',
            'data' => $result,
        ]);
    }
}
