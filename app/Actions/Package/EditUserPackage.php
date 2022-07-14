<?php
namespace App\Actions\Package;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\users_packages;
use App\Actions\Product\SingleCharge;
use App\Models\Package;

class EditUserPackage
{
    use AsAction;

    public function rules()
    {
        return [
            'package' => ['required'],
        ];
    }

    public function handle(User $user, int $packageId, int $option = null, string $paymentMethod)
    {
        $priceId = "";
        $package = Package::where('id', $packageId)->first();

        switch ($packageId) {
            case 1:
                users_packages::where('user', $user->id)->delete();
                
                users_packages::create([
                    'user' => $user->id,
                    'package' => $packageId,
                    'option_id' => $option,
                ]);
                return ['success' => true];
                break;
            case 2:
                switch ($option) {
                    case 1:
                        $priceId = "price_1L1J4IDmG9G5COvNDcvruWdq";
                        break;
                    case 2:
                        $priceId = "price_1L1J4IDmG9G5COvN1u1YrJt8";
                        break;
                    case 3:
                        $priceId = "price_1L1J4IDmG9G5COvNDlLQPSNT";
                        break;
                    
                    default:
                        break;
                }

                try {
                    $user->subscription('daily')->cancel();
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $user->newSubscription(
                    'monthly', $priceId
                )->create($paymentMethod);

                users_packages::where('user', $user->id)->delete();
            
                users_packages::create([
                    'user' => $user->id,
                    'package' => $packageId,
                    'option_id' => $option,
                ]);

                return ['success' => true];
                break;
            case 3:
                try {
                    $user->subscription('monthly')->cancel();
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $user->newSubscription(
                    'daily', 'price_1L1J31DmG9G5COvNNi4l44e5'
                )->create($paymentMethod);

                users_packages::where('user', $user->id)->delete();

                users_packages::create([
                    'user' => $user->id,
                    'package' => $packageId,
                    'option_id' => $option,
                ]);

                return ['success' => true];
                break;
            
            default:
                break;
        }
    }

    public function asController(Request $request)
    {
        return response()->json($this->handle(
            $request->user(),
            $request->input('package'),
            $request->input('option'),
            $request->input('paymentMethod')
        ));
    }
}