<?php
namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Waypoint;
class GetWaypoints
{
    use AsAction;

    public function handle()
    {
        return Waypoint::all();
    }

    public function asController(Request $request)
    {
        // $this->handle();

        return response()->json(['success' => true, 'data' => $this->handle()]);
    }
}
