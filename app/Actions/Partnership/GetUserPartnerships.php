<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Partnership;
use App\Models\partnership_user;


class GetUserPartnerships
{
    use AsAction;

    public function handle(int $userId)
    {
        $userPartnerships = partnership_user::where('user_id', $userId)->get();
        $partnerships = Partnership::whereIn('id', $userPartnerships->pluck('partnership_id'))->get();

        return ['success' => true, 'partnerships' => $partnerships, 'userPartnerships' => $userPartnerships];
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request->input('userId')
        );
    }
}
