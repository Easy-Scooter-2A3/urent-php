<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\order_product;
use App\Models\partnership_products;

class GetOrderProducts
{
    use AsAction;

    public function handle(int $orderId)
    {
        //TODO: check if order belongs to user
        $order = Order::where('id', $orderId);
        if ($order->count() == 0) {
            return ['success' => false, 'message' => 'Order not found'];
        }

        $order = $order->first();
        if (auth()->user()->id != $order->user_id) {
            return ['success' => false, 'message' => 'Order not found'];
        }

        $products = order_product::where('order_id', $orderId)->get();

        $productsData = [];
        foreach ($products as $key => $product) {
            $id = $product->product_id;
            $_product = Product::where('id', $id)->first();
            $name = $_product->name;

            $productsData[$id]['name'] = $name;
            $productsData[$id]['nb'] = $product->quantity;
            $productsData[$id]['price'] = $product->price;
            $productsData[$id]['voucher'] = $product->voucher;
        }

        return ['success' => true, 'data' => $productsData];
    }

    public function asController(Request $request, $orderId)
    {
        return response()->json($this->handle($orderId));
    }
}