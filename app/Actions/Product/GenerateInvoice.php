<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use App\Models\order_product;

class GenerateInvoice
{
    use AsAction;

    public function handle(int $id)
    {   
        $ids_product = order_product::where('order_id', $id)->first();
        $products = Product::whereIn('id', $ids_product)->get();

        foreach ($products as $product) {
            $product->quantity = $ids_product->quantity;
        }
        
        $file ='user.pdf';
        $pdf = pdf::loadView($file, ['order' => Order::find($id), 'product' => $product]);
        return $pdf->download('invoice.pdf'); 
        return $pdf->stream();
        return ['success' => true];
    }

    public function asController(Request $request, $id)
    {
        return $this->handle(
            $id
        );
    }
}