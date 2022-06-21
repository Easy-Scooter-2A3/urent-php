<?php

namespace App\Actions\User;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Token;


class UserActivation
{
    use AsAction;

    public function handle(string $token1)
    {
        $token = Token::where('token', $token1)->first();
        if (!$token || !is_null($token->used_at) || $token->action != 'confirm-account') {
            return response()->json(['success' => false]);
        }
        if ($token) {
            $user = User::where('activation_token', $token->id)->first();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found']);
            }
            $user->isActive = true;
            $user->activation_token = null;
            $token->used_at = now();
            $user->save();
            $token->save();
            return response()->redirectToRoute('login');
        }
        return abort(404);
    }

    public function asController(Request $request, string $token)
    {
        return $this->handle(
            $token
        );
    }
}
