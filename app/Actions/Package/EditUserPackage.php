<?php
namespace App\Actions\Package;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\users_packages;
use App\Actions\Product\SingleCharge;

class EditUserPackage
{
    use AsAction;

    public function rules()
    {
        return [
            'package' => ['required'],
        ];
    }

    public function handle(User $user, int $package, int $option = null)
    {
        SingleCharge::run($paymentMethod, $total, $mode);

        users_packages::where('user', $user->id)->delete();
        
        users_packages::create([
            'user' => $user->id,
            'package' => $package,
            'option_id' => $option,
        ]);
    }

    public function asController(Request $request)
    {
        // TODO: Implement payement() method.
        $this->handle(
            $request->user(),
            $request->post('package'),
            $request->post('option')
        );

        return response()->json(['success' => true]);
    }
}