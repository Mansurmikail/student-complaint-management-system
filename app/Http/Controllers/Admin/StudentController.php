<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;

class StudentController extends Controller
{
    /**
     * Display and search student accounts.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'student')
            ->orderBy('name');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('matric_number', 'like', "%{$search}%");
            });
        }

        $students = $query->paginate(10)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    /**
     * Display an individual student profile and complaint history.
     */
    public function show($id)
    {
        $student = User::where('role', 'student')
            ->withCount('complaints')
            ->findOrFail($id);

        $complaints = $student->complaints()
            ->latest()
            ->get();

        return view('admin.students.show', compact('student', 'complaints'));
    }

    /**
     * Display the student editing form.
     */
    public function edit($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update student information.
     */
    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($student->id),
            ],
            'matric_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'matric_number')->ignore($student->id),
            ],
            'department' => ['nullable', 'string', 'max:255'],
            'faculty' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $student->update($validated);

        return redirect()
            ->route('admin.students.show', $student->id)
            ->with('success', 'Student information updated successfully.');
    }

        /**
     * Activate or deactivate a student account.
     */
    public function toggleStatus($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        $student->update([
            'is_active' => !$student->is_active,
        ]);

        $message = $student->is_active
            ? 'Student account activated successfully.'
            : 'Student account deactivated successfully.';

        return redirect()
            ->route('admin.students.show', $student->id)
            ->with('success', $message);
    }

    /**
         * Send a secure password-reset link to a student.
         */
        public function sendPasswordReset($id)
        {
            $student = User::where('role', 'student')->findOrFail($id);

            $status = Password::sendResetLink([
                'email' => $student->email,
            ]);

            if ($status === Password::RESET_LINK_SENT) {
                return redirect()
                    ->route('admin.students.show', $student->id)
                    ->with('success', 'Password reset link sent successfully to the student.');
            }

            return redirect()
                ->route('admin.students.show', $student->id)
                ->withErrors([
                    'password_reset' => __($status),
                ]);
        }
}
