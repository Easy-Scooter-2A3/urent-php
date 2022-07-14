<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Mail\NewUser;
use App\Models\Token;
use Lorisleiva\Actions\Concerns\AsAction;
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    use AsAction;

    public function handle(array $input)
    {
        return $this->create($input);
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'location' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            // 'partner_code' => ['string', 'max:255'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'location' => $input['location'],
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
            'partner_code' => $input['partner_code'] ?? null,
            'isActive' => false,
        ]);

        $bytes = random_bytes(32);
        $token = bin2hex($bytes);
        $tk = Token::create([
            'user_id' => $user->id,
            'token' => $token,
            'action' => 'confirm-account'
        ]);
        $user->activation_token = $tk->id;
        $user->save();
        Mail::to("kazuh.m@protonmail.ch")->send(new NewUser($user, $token));

        return $user;
    }
}
