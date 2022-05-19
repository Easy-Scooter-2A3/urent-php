<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Partnership;
use App\Models\partnership_user;


class GetPartnershipsDetails
{
    use AsAction;

    public function handle($partnershipsIds)
    {
        $partnerships = [];
        foreach ($partnershipsIds as $key => $partnershipId) {   
            $partnership = Partnership::where('id',$partnershipId)->get();
            $users = GetPartnershipUsers::run($partnership->pluck('id'));

            //TODO: add products

            $partnerships[$partnershipId]['partnership'] = $partnership;
            $partnerships[$partnershipId]['users'] = $users['users']; 
        }

        return ['success' => true, 'data' => $partnerships];
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request->input('partnershipsIds')
        );
    }
}
