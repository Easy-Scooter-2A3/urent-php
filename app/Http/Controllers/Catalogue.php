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
        $data = GetProductsDetails::run();

        return view('catalogue.catalogue', [
            'attributes' => Attribute::all(),
            'attributesList' => $data['attributes'][0],
            'products' => $data['data'],
        ]);
    }
}
