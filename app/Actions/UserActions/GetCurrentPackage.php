<?php
namespace App\Actions\UserActions;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\User;
use App\Models\users_packages;

class GetCurrentPackage
{
    use AsAction;

    public function handle(User $user)
    {
        $currentPackage = users_packages::where('user', $user->id)->first();
        if ($currentPackage) {
            return $currentPackage->package;
        }
        return -1;
    }
}