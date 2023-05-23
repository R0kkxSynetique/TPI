<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     * @param  array<string, string>  $input
     * @return \App\Models\User
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'email' => ['string', 'unique:users,email'],
            'username' => ['string', 'unique:users,username'],
            'lastname' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'birthdate' => ['required', 'date'],
            'password' => ['required', 'string'],
        ], [
            'email' => __('validation.unique'),
            'username' => __('validation.unique'),
        ])->validateWithBag('createUser');

        return User::create([
            'lastname' => $input['lastname'],
            'firstname' => $input['firstname'],
            'birthdate' => $input['birthdate'],
            'email' => $input['email'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
