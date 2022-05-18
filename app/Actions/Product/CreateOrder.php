<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\order_product;

class CreateOrder
{
    use AsAction;

    public function handle($total, $paymentMethod, $recu)
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();

        foreach ($cart as $item) {
            $product = Product::find($item->product_id);
            $product->stock -= $item->stock;
            $product->save();
        }

        Cart::where('user_id', auth()->user()->id)->delete();

        Order::create([
            'user_id' => Auth()->user()->id,
            'status' => 'pending',
            'delivery_place' => 'ratio',
            'delivery_date' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'transporter_tracking_number' => '123',
            'total_price' => $total,
            'total_tax' => 20.0,
            'total_discount' => 0.0,
            'payment_method' => $paymentMethod,
            'recu' => $recu,
        ]);

        foreach ($cart as $item) {
            order_product::create([
                'order_id' => Order::where('user_id', Auth()->user()->id)->orderBy('created_at', 'desc')->first()->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }

        return response()->json(['success' => true]);
    }

}
