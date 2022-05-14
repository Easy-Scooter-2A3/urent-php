<?php
namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;

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
        ];
    }

    public function handle(string $name, string $price, string $description, string $stock)
    {
        Product::create([
            'name' => $name,
            'price' => $price,
            'description' => $description,
            'stock' => $stock,
        ]);
    }

    public function asController(Request $request)
    {
        $this->handle(
            $request->post('name'),
            $request->post('price'),
            $request->post('description'),
            $request->post('stock')
        );

        return response()->json(['success' => true]);
    }
}