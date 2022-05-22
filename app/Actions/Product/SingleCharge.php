<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Laravel\Cashier\Payment;
use Laravel\Cashier\Concerns\ManagesPaymentMethods;

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
        $total *= 100.0;

        $payment = auth()->user()->charge(
            $total, $paymentMethod
        );

        if ($payment->isSucceeded()) {
            $recu = $payment->__get('charges')->data[0]->__get('receipt_url');

            switch ($mode) {
                case 'cart':
                    CreateOrder::dispatch($total, $paymentMethod, $recu);
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
