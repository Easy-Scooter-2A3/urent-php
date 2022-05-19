<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\partnership_product;
use Illuminate\Support\Facades\Log;


class GetPartnershipProductsList
{
    use AsAction;

    public function handle($partnershipsId)
    {
        $partnershipProducts = partnership_product::where('partnership_id', $partnershipsId)->get();

        return ['success' => true, 'data' => $partnershipProducts];
    }

    public function asController(Request $request, $id)
    {
        return $this->handle(
            $id
        );
    }
}
