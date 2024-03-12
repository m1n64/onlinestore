<?php

namespace App\Http\Actions\Storage\Api\Files;

use App\Models\File;

class RenameAction
{
    /**
     * @param File $files
     */
    public function __construct(
        protected File     $files,
    )
    {
    }

    /**
     * @param int $id
     * @param int $userId
     * @param string $name
     * @return File
     */
    public function __invoke(int $id, int $userId, string $name): File
    {
        $this->files::whereId($id)
            ->where("user_id", $userId)
            ->update([
                'name' => $name,
            ]);

        return $this->files->find($id);
    }
}
