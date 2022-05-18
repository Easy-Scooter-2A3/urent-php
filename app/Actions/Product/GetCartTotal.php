<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class GetCartTotal
{
    use AsAction;

    public function handle()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        $total = 0;

        $productsInCart = [];

        foreach ($cart as $item) {
            $productsInCart[$item->product_id] = $item->quantity;
        }

        $products = Product::whereIn('id', array_keys($productsInCart))->get();

        foreach ($products as $product) {
            $total += $product->price * $productsInCart[$product->id]; //get price
        }

        return ['success' => true, 'data' => $total];
    }

    public function asController(Request $request)
    {
        return response()->json($this->handle());
    }
}
