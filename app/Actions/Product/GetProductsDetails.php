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
            'products' => ['required'],
        ];
    }

    public function handle($productIds)
    {
        // TODO: pagination -> action
        $attributes = Attribute::all();

        $attributesMap = [];
        $products = [];

        if (count($productIds) > 0) {
            $products = Product::whereIn('id', $productIds)->get();
            $_attributes = attribute_product::whereIn('product_id', $productIds)->get();

            foreach ($_attributes as $key => $_attribute) {
                if (!isset($attributesMap[$_attribute->product_id])) {
                    $attributesMap[$_attribute->product_id] = [];
                }

                $attributesMap[$_attribute->product_id][] = $_attribute['attribute_id'];
            }
        };

        return ['success' => true, 'data' => $products, 'attributes' => [$attributesMap]];
    }

    public function asController(Request $request)
    {
        return response()->json($this->handle(
            $request->post('products'),
        ));
    }
}