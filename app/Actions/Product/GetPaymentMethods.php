<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;

class GetPaymentMethods
{
    use AsAction;

    public function handle(User $user)
    {
        return response()->json(['success' => true, 'data' => $user->paymentMethods()->all()]);
    }

    public function asController(Request $request)
    {
        return $this->handle(
            $request->user(),
        );
    }
}
