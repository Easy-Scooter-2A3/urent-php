<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Partnership;
use App\Models\partnership_product;
use App\Models\partnership_user;
use Illuminate\Support\Facades\Log;

class GetCartTotal
{
    use AsAction;

    public function handle()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->get();
        $total = 0;
        $totalWithoutVoucher = 0;

        $productsInCart = [];

        foreach ($cart as $item) {
            $productsInCart[$item->product_id] = $item->quantity;
        }

        $products = Product::whereIn('id', array_keys($productsInCart))->get();

        $userPartnership = partnership_user::where('user_id', auth()->user()->id)->first();

        $voucher = 0;
        if ($userPartnership) {
            $userPartnership = Partnership::where('id', $userPartnership->partnership_id)->first();
            $voucher = $userPartnership->voucher;
        }

        $partnershipProducts = partnership_product::whereIn('product_id', array_keys($productsInCart))->get();
        $vouchersApplied = [];
        $productsBasePrice = [];
        foreach ($products as $product) {
            $pprice = $product->price;
            $totalWithoutVoucher += $pprice * $productsInCart[$product->id];
            $productsBasePrice[$product->id] = $pprice;
            
            if ($userPartnership && isset($partnershipProducts[$product->id])) {
                $vouchersApplied[$product->id] = $voucher;
                $pprice = $pprice - ($pprice * $voucher / 100);
            }
            $total += $pprice * $productsInCart[$product->id]; //get price
        }

        return ['success' => true, 'productsBasePrice' => $productsBasePrice, 'total' => $total, 'voucher' => $voucher, 'totalWithoutVoucher' => $totalWithoutVoucher, 'vouchersApplied' => $vouchersApplied];
    }

    public function asController(Request $request)
    {
        return response()->json($this->handle());
    }
}
