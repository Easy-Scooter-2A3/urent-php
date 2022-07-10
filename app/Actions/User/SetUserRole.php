<?php

namespace App\Actions\User;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;


class SetUserRole
{
    use AsAction;

    public function handle(int $role, int $id)
    {
        $user = User::find($id);
        $user->isAdmin = $role;
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
