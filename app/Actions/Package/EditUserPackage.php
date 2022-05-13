<?php
namespace App\Actions\Package;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\users_packages;

class EditUserPackage
{
    use AsAction;

    public function rules()
    {
        return [
            'package' => ['required'],
        ];
    }

    public function handle(User $user, int $package)
    {
        users_packages::where('user', $user->id)->delete();
        
        users_packages::create([
            'user' => $user->id,
            'package' => $package,
        ]);
    }

    public function asController(Request $request)
    {
        // TODO: Implement payement() method.
        $this->handle(
            $request->user(),
            $request->post('package')
        );

        return response()->json(['success' => true]);
    }
}