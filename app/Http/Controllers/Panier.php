<?php

namespace App\Http\Controllers;

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
        if (count($cart) > 0) {
            $data = GetProductsDetails::run($cart);
        } else {
            $data = [
                'attributes' => [[]],
                'data' => [],
            ];
        }

        return view('catalogue.panier', [
            'attributes' => Attribute::all(),
            'attributesList' => $data['attributes'][0],
            'products' => $data['data'],
        ]);
    }
}
