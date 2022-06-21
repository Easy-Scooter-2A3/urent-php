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

    public function handle($partnershipsId)
    {
        $partnershipUsers = partnership_user::where('partnership_id', $partnershipsId)->first();
        $users = User::whereIn('id', $partnershipUsers->pluck('user_id'))->get(['id','name']);

        return ['success' => true, 'users' => $users];
    }
}
