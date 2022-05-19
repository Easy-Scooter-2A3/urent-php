<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\partnership_user;
use Illuminate\Support\Facades\Log;


class GetPartnershipUsers
{
    use AsAction;

    public function handle($partnershipsIds)
    {
        $partnershipUsers = partnership_user::whereIn('partnership_id', $partnershipsIds)->get();
        $users = User::whereIn('id', $partnershipUsers->pluck('user_id'))->get(['id','name']);

        return ['success' => true, 'users' => $users];
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request->input('userId')
        );
    }
}
