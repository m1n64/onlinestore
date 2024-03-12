<?php

namespace App\Http\Actions\Admin\Api\Users;

use App\Enums\RoleCodesEnum;
use App\Enums\RolesEnum;
use App\Mail\UserChangeRole;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SetRoleAction
{

    /**
     * @param int $id
     * @param string $role
     * @return User
     */
    public function __invoke(int $id, string $role): User
    {
        $roleName = match ($role) {
            RoleCodesEnum::User->value => RolesEnum::User->value,
            RoleCodesEnum::Moder->value => RolesEnum::Moder->value,
            RoleCodesEnum::Admin->value => RolesEnum::Admin->value,
        };

        $user = User::where("id", $id);

        $userInfo = $user->first();

        Mail::to($userInfo)->send(new UserChangeRole($userInfo, $roleName));

        $newUserRoleChange = [
            "role" => $role,
            "role_name" => $roleName,
            "max_files_size" => 100,
        ];

        if ($role === RoleCodesEnum::Admin->value) $newUserRoleChange["max_files_size"] = -1;

        $user->update($newUserRoleChange);

        return User::find($id);
    }
}
