<?php

namespace App\Actions\Partnership;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Partnership;


class GetPartnerships
{
    use AsAction;

    public function handle()
    {
        return Partnership::all();
    }

    public function asController(Request $request)
    {
        return $this->handle();
    }
}
