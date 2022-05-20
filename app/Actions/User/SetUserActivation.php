<?php

namespace App\Actions\User;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;


class SetUserActivation
{
    use AsAction;

    public function handle(int $active, int $id)
    {
        $user = User::find($id);
        $user->isActive = $active;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function asController(Request $request, int $id)
    {
        return $this->handle(
            $request->input('role'),
            $id
        );
    }
}
