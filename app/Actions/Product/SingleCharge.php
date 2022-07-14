<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Laravel\Cashier\Payment;
use Laravel\Cashier\Concerns\ManagesPaymentMethods;
use Illuminate\Support\Facades\Log;

class SingleCharge
{
    use AsAction;

    public function rules()
    {
        return [
            'paymentMethod' => ['required'],
        ];
    }

    public function handle(string $paymentMethod, float $total, string $mode)
    {
        $voucher = 0;
        switch ($mode) {
            case 'cart':
                $cartPrice = GetCartTotal::run();

                $totalWithoutVoucher = $cartPrice['totalWithoutVoucher'];
                $voucher = $cartPrice['voucher'];
                $vouchersApplied = $cartPrice['vouchersApplied'];
                $productsBasePrice = $cartPrice['productsBasePrice'];
                
                if ($total != $cartPrice['total']) {
                    Log::debug('total is not equal to cart price');
                    return response()->json(['success' => false, 'message' => 'cart error'])->setStatusCode(400);
                }
                $total = $cartPrice['total'];

                //check stock
                $cart = Cart::where('user_id', auth()->user()->id)->get();
                foreach ($cart as $item) {
                    $productsInCart[$item->product_id] = $item->quantity;
                }
                $products = Product::whereIn('id', array_keys($productsInCart))->get();
                foreach ($products as $product) {
                    if ($product->stock < $productsInCart[$product->id]) {
                        Log::debug('stock is not enough');
                        return response()->json(['success' => false, 'message' => 'Not enough stock']);
                    }
                }

                break;

            default:
                break;
        }

        $total *= 100.0;
        $totalWithoutVoucher *= 100.0;
        //check promo code

        $payment = auth()->user()->charge(
            $total, $paymentMethod
        );

        if ($payment->isSucceeded()) {
            $recu = $payment->__get('charges')->data[0]->__get('receipt_url');

            switch ($mode) {
                case 'cart':
                    CreateOrder::dispatch($totalWithoutVoucher, $paymentMethod, $recu, $vouchersApplied, $productsBasePrice);
                    //TODO: send mail
                    break;
                case 'package':
                    
                    break;
                    
                
                default:
                    break;
            }

            return response()->json(['success' => true, 'receipt_url' => $recu]);
        }

        return response()->json(['success' => false, 'message' => $payment->__get('failure_message')]);
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request->input('paymentMethod'),
            $request->input('total'),
            $request->input('mode'),
        );
    }
}
