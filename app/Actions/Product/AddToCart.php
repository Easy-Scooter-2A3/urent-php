<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;

class AddToCart
{
    use AsAction;

    public function handle(int $productId, int $quantity)
    {
        $product = Product::find($productId);
        //check stock
        $product->stock = $product->stock - $quantity;
        $product->save();

        //add to cart
    }

    public function asController(Request $request)
    {
        $this->handle(
            $request->post('productId'),
            $request->post('quantity')
        );

        return response()->json(['success' => true]);
    }
}
