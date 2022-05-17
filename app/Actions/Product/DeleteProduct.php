<?php
namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;

class DeleteProduct
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
        Product::destroy($products);
    }

    public function asController(Request $request)
    {
        $this->handle(
            $request->post('products'),
        );

        return response()->json(['success' => true]);
    }
}