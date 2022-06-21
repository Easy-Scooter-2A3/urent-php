<?php

namespace App\Actions\User;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ConvertUserFidelity
{
    use AsAction;

    public function handle()
    {
        $user = User::find(Auth::id());
        $user->applyBalance(round(($user->fidelity_points * 0.2) * 100), 'Conversion de points de fidélité');
        $user->fidelity_points = 0;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function asController(Request $request)
    {
        return $this->handle();
    }
}
