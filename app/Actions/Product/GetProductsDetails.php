<?php
namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;

class GetProductsDetails
{
    use AsAction;

    public function rules()
    {
        return [
            'products' => ['required'],
        ];
    }

    public function handle($products)
    {
        if (count($products) > 0) {
            $products = Product::whereIn('id', $products)->get();
        };
        
        return ['success' => true, 'data' => $products];
    }

    public function asController(Request $request)
    {
        return response()->json($this->handle(
            $request->post('products'),
        ));
    }
}