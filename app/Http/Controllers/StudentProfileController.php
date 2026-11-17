<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StudentProfileController extends Controller
{
    /**
     * Display the logged-in student's profile.
     */
    public function edit(): View
    {
        $student = auth()->user();

        return view('student.profile', compact('student'));
    }

    /**
     * Update permitted student profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $student = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $student->id,
            ],
            'department' => ['nullable', 'string', 'max:255'],
            'faculty' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $student->fill($validated);

        // Require email verification again if the email address changes.
        if ($student->isDirty('email')) {
            $student->email_verified_at = null;
        }

        $student->save();

        return redirect()
            ->route('student.profile.edit')
            ->with('success', 'Your profile has been updated successfully.');
    }
}
