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

            'level' => [
                'required',
                Rule::in(['ND I', 'ND II', 'HND I', 'HND II']),
            ],

            'trade' => [
                'required',
                Rule::in($trades),
            ],

            'phone' => ['required', 'string', 'max:30'],

            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'matric_number' => $input['matric_number'],
            'faculty' => $input['faculty'],
            'department' => $input['department'],
            'level' => $input['level'],
            'trade' => $input['trade'],
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
