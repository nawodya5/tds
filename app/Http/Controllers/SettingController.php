<?php

namespace App\Http\Controllers;



use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::query()->first();

        return view('setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::query()->first();

        $validated = $request->validate([
            'teacher_name' => ['required', 'string', 'max:255'],
            'institute_name' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'default_subject' => ['required', 'string', 'max:100'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        unset($validated['logo']);

        if ($request->hasFile('logo')) {
            if ($setting?->logo) {
                Storage::disk('public')->delete($setting->logo);
            }

            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($setting) {
            $setting->update($validated);
        } else {
            $setting = Setting::create($validated);
        }

        return redirect()->route('settings.edit')->with('success', 'Settings saved successfully.');
    }
}
