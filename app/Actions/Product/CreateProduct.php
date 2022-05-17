<?php
namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\attribute_product;

class CreateProduct
{
    use AsAction;

    public function rules()
    {
        return [
            'name' => ['required'],
            'price' => ['required'],
            'description' => ['required'],
            'stock' => ['required'],
            'available' => ['required'],
            'attributes' => ['required'],
        ];
    }

    public function handle(string $name, string $price, string $description, string $stock, bool $available, $attributes)
    {

        $product = Product::create(
            [
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'stock' => $stock,
                'available' => $available,
            ]
        );

        foreach ($attributes as $key => $attribute) {
            attribute_product::create(
                [
                    'product_id' => $product->id,
                    'attribute_id' => $attribute,
                ]
            );
        }
    }

    public function asController(Request $request)
    {
        $this->handle(
            $request->post('name'),
            $request->post('price'),
            $request->post('description'),
            $request->post('stock'),
            $request->post('available'),
            $request->post('attributes'),
        );

        return response()->json(['success' => true]);
    }
}