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
            'payment_method' => ['required'],
        ];
    }

    public function handle(Request $request, string $paymentMethod, int $total)
    {
        $payment = $request->user()->charge(
            $total, $paymentMethod
        );

        if ($payment->isSucceeded()) {
            $recu = $payment->__get('charges')->data[0]->__get('receipt_url');
            return response()->json(['success' => true, 'receipt_url' => $recu]);
        }

        return response()->json(['success' => false, 'message' => $payment->__get('failure_message')]);
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request,
            $request->input('payment_method'),
            $request->input('total')
        );
    }
}
