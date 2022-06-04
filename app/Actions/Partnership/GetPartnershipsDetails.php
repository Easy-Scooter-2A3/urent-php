<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Partnership;
use App\Models\partnership_user;


class GetPartnershipsDetails
{
    use AsAction;

    public function handle($partnershipsId)
    {

        //TODO: check   -> data   or ['data']
        $partnership = Partnership::find($partnershipsId);
        $users = GetPartnershipUsers::run($partnershipsId)['users'];
        $products = GetPartnershipProductsList::run($partnershipsId)['data'];

        return ['success' => true, 'partnership' => $partnership, 'users' => $users, 'products' => $products];
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request->input('partnershipsId')
        );
    }
}
