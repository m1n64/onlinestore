<?php

namespace App\Http\Actions\Storage\Api\Folders;

use App\Models\Folder;

class DeleteAction
{
    /**
     * @param Folder $folders
     */
    public function __construct(
        protected Folder $folders,
    )
    {
    }

    /**
     * @param int $id
     * @param int $userId
     * @return void
     */
    public function __invoke(int $id, int $userId): void
    {
        $this->folders->where("id", $id)
            ->where("user_id", $userId)
            ->delete();

    }
}
