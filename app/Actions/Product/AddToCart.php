<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Actions\Product\SetCart;


class AddToCart
{
    use AsAction;

    public function handle(int $productId, int $quantity)
    {
        $product = Product::find($productId);
        if ($product->stock < $quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock']);
        }

        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->first();
        $quantityFinal = $quantity;
        if ($cart) {
            $quantityFinal = $cart->quantity + $quantity;
        }
        SetCart::run($productId, $quantityFinal);

        return response()->json(['success' => true]);
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request->post('productId'),
            $request->post('quantity')
        );
    }
}
