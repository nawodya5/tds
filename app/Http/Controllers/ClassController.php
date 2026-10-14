<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Location;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // Display classes
    public function index()
    {
        $classes = ClassModel::with(['location', 'days'])
            ->latest()
            ->paginate(10);

        $locations = Location::where('status', true)
            ->orderBy('name')
            ->get();

        return view('classes', compact('classes', 'locations'));
    }

    // Store a class
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'name' => ['required', 'string', 'max:255'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'status' => ['sometimes', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status', true);

        ClassModel::create($validated);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    // Update a class
    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'name' => ['required', 'string', 'max:255'],
            'monthly_fee' => ['required', 'numeric', 'min:0'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'status' => ['sometimes', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status', true);

        $class->update($validated);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    // Soft delete a class
    public function destroy(ClassModel $class)
    {
        $class->delete();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class deleted successfully.');
    }
}
