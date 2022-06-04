<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Partnership;
use App\Models\partnership_user;


class GetUserPartnership
{
    use AsAction;

    public function handle(int $userId)
    {
        $partnership = null;
        $userPartnership = partnership_user::where('user_id', $userId)->first();
        if ($userPartnership) {
            $partnership = Partnership::where('id', $userPartnership->partnership_id)->first();
        }

        return ['success' => true, 'partnership' => $partnership];
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request->input('userId')
        );
    }
}
