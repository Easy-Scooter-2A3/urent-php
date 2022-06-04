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
        $order = Order::find($input);

        return ['success' => true, 'data' => $order];
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
