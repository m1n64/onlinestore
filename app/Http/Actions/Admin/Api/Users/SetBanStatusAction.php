<?php

namespace App\Http\Actions\Admin\Api\Users;

use App\Mail\UserBanned;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SetBanStatusAction
{

    /**
     * @param int $id
     * @param bool $status
     * @return User
     */
    public function __invoke(int $id, bool $status): User
    {
        $user = User::where("id", $id);

        $userInfo = $user->first();
        Mail::to($userInfo)->send(new UserBanned($userInfo, $status));

        $user->update([
            'is_banned' => $status,
        ]);

        return User::find($id);
    }
}
