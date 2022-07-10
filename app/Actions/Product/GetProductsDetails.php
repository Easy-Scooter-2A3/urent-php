<?php
namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\attribute_product;
use Illuminate\Support\Facades\Log;
use App\Models\order_product;

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

        $product = Product::find($productId);
        $attributes = attribute_product::where('product_id', $productId)->get();

        $nbAchats = 0;
        $nbAchats = order_product::where('product_id', $productId)->pluck('quantity')->sum();

        return ['success' => true, 'data' => $product, 'attributes' => $attributes, 'nbAchats' => $nbAchats];
    }

    public function asController(Request $request)
    {
        return response()->json($this->handle(
            $request->post('product'),
        ));
    }
}