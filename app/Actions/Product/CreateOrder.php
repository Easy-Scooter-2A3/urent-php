<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\order_product;
use App\Models\User;

class CreateOrder
{
    use AsAction;

    public function handle($total, $paymentMethod, $recu)
    {
        $userId = auth()->user()->id;
        $cart = Cart::where('user_id', $userId)->get();

        foreach ($cart as $item) {
            $product = Product::find($item->product_id);
            $product->stock -= $item->stock;
            $product->save();
        }

        Cart::where('user_id', $userId)->delete();

        Order::create([
            'user_id' => $userId,
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
                'order_id' => Order::where('user_id', $userId)->orderBy('created_at', 'desc')->first()->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }

        $user = User::find($userId);

        $priceInEuro = $total / 100.0;

        $bonusNb = floor($priceInEuro / 100);
        
        $user->fidelity_points += intval((1 * $bonusNb) + round(0.3 * $priceInEuro));
        $user->save();

        return response()->json(['success' => true]);
    }

}
