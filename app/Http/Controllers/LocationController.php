<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // Display locations
    public function index()
    {
        $locations = Location::with('classes')
            ->orderBy('name')
            ->get();

        return view('location', compact('locations'));
    }

    // Store a location
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status', true);

        Location::create($validated);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location created successfully.');
    }

    // Update a location
    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => ['sometimes', 'boolean'],
        ]);

        $validated['status'] = $request->boolean('status', true);

        $location->update($validated);

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location updated successfully.');
    }

    // Soft delete a location
    public function destroy(Location $location)
    {
        if ($location->classes()->exists()) {
            return redirect()
                ->route('locations.index')
                ->with('error', 'Cannot delete a location that has classes.');
        }

        $location->delete();

        return redirect()
            ->route('locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
