<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

use App\Actions\Fortify\PasswordValidationRules;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Socialite\Facades\Socialite;



class Authentication extends Controller
{
    use PasswordValidationRules;

    public function socialAuth(Request $request, $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function githubLogin()
    {
        return Socialite::driver('github')->redirect();
    }

    public function socialAuthCallback(Request $request, $driver)
    {
        $githubUser = Socialite::driver($driver)
            ->scopes(['user:email', 'user:read'])
            ->stateless()
            ->user();

        $user = null;
        switch ($driver) {
            case 'github':
                $user = User::where('github_id', $githubUser->id)->first();
                break;
            
            default:
                break;
        }

        if ($user) {
            Auth::login($user);
            return redirect('/');
        }

        $data = [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_id' => $githubUser->id,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
            'isActive' => true,
            'password' => 'github',
            'password_confirmation' => 'github',
            'location' => 'default',
            'phone' => 'default',
            'oauth' => $driver,
        ];

        $user = CreateNewUser::run($data);
        switch ($driver) {
            case 'github':
                $user->github_id = $githubUser->id;
                $user->github_token = $githubUser->token;
                $user->github_refresh_token = $githubUser->refreshToken;
                break;

            default:
                break;
        }
        $user->save();

        Auth::login($user);

        return redirect()->to('/');
    }

    public function resetPassword(Request $request, String $token)
    {
        return view('auth.reset-password', ['email' => $request->email ?? '']);
    }

    public function resetPasswordSubmit(Request $request) {
        print_r($request->all());
        $validator = Validator::make($request->all(), [
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => $this->passwordRules(),
        ]);
        $validator->validate();

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();

                // event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function forgotPassword(Request $request)
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        $validator->after(function ($validator) use ($request) {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $validator->errors()->add('email', 'User not found');
            }
        })->validate();

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return view('auth.forgot-password', ['status' => 
            Password::RESET_LINK_SENT ? "Reset link sent to your email" : "Error sending reset link"
        ]);
    }
}
