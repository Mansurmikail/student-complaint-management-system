<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered student.
     *
     * @param array<string, string> $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],

            'matric_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique(User::class, 'matric_number'),
            ],

            'faculty' => ['required', 'string', 'max:255'],

            'department' => ['required', 'string', 'max:255'],

            'phone' => ['required', 'string', 'max:30'],

            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'matric_number' => $input['matric_number'],
            'faculty' => $input['faculty'],
            'department' => $input['department'],
            'phone' => $input['phone'],
            'password' => $input['password'],
        ]);

        // Public registration must always create a student account.
        $user->forceFill([
            'role' => 'student',
        ])->save();

        return $user;
    }
}
