<?php
namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\attribute_product;
use Illuminate\Support\Facades\Log;

class GetProductsDetails
{
    use AsAction;

    public function rules()
    {
        return [
            'product' => ['required'],
        ];
    }

    public function handle($productId)
    {
        // TODO: pagination -> action
        // $attributes = Attribute::all();

        // $attributesMap = [];

        // if (count($productIds) > 0) {
        //     $products = Product::whereIn('id', $productIds)->get();
        //     $_attributes = attribute_product::whereIn('product_id', $productIds)->get();
        // } else {
        //     $products = Product::all();
        //     $_attributes = attribute_product::all();
        // }

        // foreach ($_attributes as $key => $_attribute) {
        //     if (!isset($attributesMap[$_attribute->product_id])) {
        //         $attributesMap[$_attribute->product_id] = [];
        //     }

        //     $attributesMap[$_attribute->product_id][] = $_attribute['attribute_id'];
        // }

        $product = Product::find($productId);
        $attributes = attribute_product::where('product_id', $productId)->get();

        return ['success' => true, 'data' => $product, 'attributes' => $attributes];
    }

    public function asController(Request $request)
    {
        return response()->json($this->handle(
            $request->post('product'),
        ));
    }
}