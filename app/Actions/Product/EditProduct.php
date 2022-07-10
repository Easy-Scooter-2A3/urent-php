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
            'attributes' => ['required'], // check empty array
        ];
    }

    public function handle($id, string $name, string $price, string $description, string $stock, bool $available, $attributes, $image)
    {
        if ($image) {
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

            $current = Product::where('id', $id)->first()->image;
            if ($current) {
                unlink(storage_path('app/public/' . $current));
            }
            Product::where('id', $id)->update(
                [
                    'image' => $hash,
                ]
            );
        }

        Product::where('id', $id)->update(
            [
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'stock' => $stock,
                'available' => boolval($available),
            ]
        );

        $currentAttributes = attribute_product::where('product_id', $id)->get();
        foreach ($currentAttributes as $key => $currentAttribute) {
            attribute_product::destroy($currentAttribute->id); //remove
        }

        foreach (json_decode($attributes) as $key => $attribute) {
            attribute_product::create(
                [
                    'product_id' => $id,
                    'attribute_id' => $attribute,
                ]
            );
        }
    }

    public function asController(Request $request, $id)
    {
        $this->handle(
            $id,
            $request->input('name'),
            $request->input('price'),
            $request->input('description'),
            $request->input('stock'),
            $request->input('available'),
            $request->input('attributes'),
            $request->file('image'),
        );

        return response()->json(['success' => true]);
    }
}