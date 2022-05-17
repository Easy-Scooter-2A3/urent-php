<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

class SetCart
{
    use AsAction;

    public function handle(int $productId, int $quantity)
    {
        $product = Product::find($productId);

        if ($quantity == 0) {
            Cart::destroy($productId);
            return response()->json(['success' => true]);
        }

        if ($product->stock < $quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock']);
        }

        $cart = Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->first();
        if ($cart) {
            $cart->quantity = $quantity;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

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
