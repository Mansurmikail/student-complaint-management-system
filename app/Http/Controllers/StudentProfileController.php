<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

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

        $trades = [
            'Barbering',
            'Beading Works',
            'Brick/Block Moulding And Concreting',
            'Catering and Confectioneries',
            'Cosmetology',
            'Electrical Installation',
            'Fisheries',
            'Garment Making',
            'GSM Repairs and Servicing',
            'Household Products',
            'Leather Works',
            'Modern Car Repairs and Servicing',
            'Pure Water Production and Marketing',
            'Renewable Energy and Solar Inverter Energy',
            'Textile Technology',
            'Website Design and Software Development',
        ];

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

            'level' => [
                'required',
                Rule::in(['ND I', 'ND II', 'HND I', 'HND II']),
            ],

            'trade' => [
                'required',
                Rule::in($trades),
            ],

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
