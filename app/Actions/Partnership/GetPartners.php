<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\partnership_user;


class GetPartners
{
    use AsAction;

    public function handle()
    {
        return partnership_user::all();
    }

    public function asController(Request $request)
    {
        return $this->handle();
    }
}
