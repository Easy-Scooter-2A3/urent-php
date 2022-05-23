<?php
namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\attribute_product;
use Illuminate\Support\Facades\Log;

class EditProduct
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
            // 'attributes' => ['required'], // check empty array
        ];
    }

    public function handle($id, string $name, string $price, string $description, string $stock, bool $available, $attributes)
    {
        Log::debug($id);
        Log::debug($name);
        Log::debug($price);
        Log::debug($description);
        Log::debug($stock);
        Log::debug($available);
        Log::debug($attributes);

        $product = Product::where('id', $id)->update(
            [
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'stock' => $stock,
                'available' => $available,
            ]
        );

        $currentAttributes = attribute_product::where('product_id', $id)->get();
        foreach ($currentAttributes as $key => $currentAttribute) {
            attribute_product::destroy($currentAttribute->id); //remove
        }

        foreach ($attributes as $key => $attribute) {
            attribute_product::create(
                [
                    'product_id' => $id,
                    'attribute_id' => $attribute,
                ]
            );
        }
    }

    public function asController(Request $request, string $lang, $id)
    {
        $this->handle(
            $id,
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