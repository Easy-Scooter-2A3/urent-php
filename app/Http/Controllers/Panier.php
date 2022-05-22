<?php

namespace App\Http\Controllers;

use App\Actions\Product\GetCartTotal;
use App\Actions\Product\GetProductsDetails;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Cart;

class Panier extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->pluck('product_id')->toArray();
        
        $data = [];
        $quantity = [];
        foreach ($cart as $key => $cartProduct) {
            $tmp = GetProductsDetails::run($cartProduct);
            $data['data'][] = $tmp['data'];
            $data['attributes'][$cartProduct] = $tmp['attributes'];
        }

        $quantity = [];
        foreach ($data['data'] as $key => $product) {
            $quantity[$product->id] = Cart::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first()->quantity;
        }

        $total = GetCartTotal::run();

        return view('catalogue.panier', [
            'attributes' => Attribute::all(),
            'attributesList' => $data['attributes'],
            'products' => $data['data'],
            'quantity' => $quantity,
            'total' => $total['data']
        ]);
    }
}
