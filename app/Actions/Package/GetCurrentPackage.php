<?php
namespace App\Actions\Package;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\User;
use App\Models\users_packages;

class GetCurrentPackage
{
    use AsAction;

    public function handle(User $user = null)
    {
        if ($user == null) {
            return null;
        }
        $currentPackage = users_packages::where('user', $user->id)->first();

        if (!$currentPackage) {
            $currentPackage = users_packages::create([
                'user' => $user->id,
                'package' => 1,
            ]);
        }

        return $currentPackage->package;
    }
}