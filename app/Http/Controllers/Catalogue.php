<?php

namespace App\Http\Controllers;

use App\Actions\Product\GetProductsDetails;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;

class Catalogue extends Controller
{
    public function index()
    {
        $products = Product::all();
        $data = [
            'data' => [],
            'attributes' => [],
        ];
        foreach ($products as $key => $product) {
            $tmp = GetProductsDetails::run($product->id);
            $data['data'][] = $tmp['data'] ?? [];
            $data['attributes'][$product->id] = $tmp['attributes'] ?? [];
        }

        return view('catalogue.catalogue', [
            'attributes' => Attribute::all(),
            'attributesList' => $data['attributes'],
            'products' => $data['data'],
        ]);
    }
}
