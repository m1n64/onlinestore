<?php

namespace App\Http\Actions\Admin\Api\Users;

use App\Models\User;

class SetMaxFilesSizeAction
{

    /**
     * @param int $id
     * @param float $maxFilesSize
     * @return User
     */
    public function __invoke(int $id, float $maxFilesSize): User
    {
        User::where("id", $id)
            ->update([
                'max_files_size' => $maxFilesSize
            ]);

        return User::find($id);
    }
}
