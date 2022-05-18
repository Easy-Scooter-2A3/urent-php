<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Order;

class GetOrdersDetails
{
    use AsAction;

    public function rules()
    {
        return [
            'orders' => ['required'],
        ];
    }

    public function handle($input)
    {
        $orders = [];
        if (count($input) > 0) {
            $orders = Order::whereIn('id', $input)->get();
        }

        return ['success' => true, 'data' => $orders];
    }
    

    public function asController(Request $request)
    {
        return response()->json(
            $this->handle(
                $request->input('orders')
            )
        );
    }
}
