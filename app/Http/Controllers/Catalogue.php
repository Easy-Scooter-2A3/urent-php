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
        $products = Product::all()->pluck('id');
        foreach ($products as $key => $product) {
            $tmp = GetProductsDetails::run($product);
            $data['data'][] = $tmp['data'];
            $data['attributes'][] = $tmp['attributes'];
        }

        return view('catalogue.catalogue', [
            'attributes' => Attribute::all(),
            'attributesList' => $data['attributes'][0],
            'products' => $data['data'],
        ]);
    }
}
