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
            'image' => ['required'],
        ];
    }

    public function handle(string $name, string $price, string $description, string $stock, bool $available, $attributes, $image)
    {
        $type = $image->getMimeType();
        $extension = $image->getClientOriginalExtension();
        $size = $image->getSize();
        if ($size > 2097152) {
            return response()->json(['error' => 'File size is too big'], 400);
        }

        if (!in_array($type, ['image/jpeg', 'image/png', 'image/jpg'])) {
            return response()->json(['error' => 'Wrong file type'], 400);
        }

        $hash = $image->hashName();
        $image->storeAs('public/images', $hash);

        $product = Product::create(
            [
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'stock' => $stock,
                'available' => json_decode($available),
                'image' => $hash,
            ]
        );

        foreach (json_decode($attributes) as $key => $attribute) {
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
            $request->file('image'),
        );

        return response()->json(['success' => true]);
    }
}