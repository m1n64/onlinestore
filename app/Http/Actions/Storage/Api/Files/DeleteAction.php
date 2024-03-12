<?php

namespace App\Http\Actions\Storage\Api\Files;

use App\Models\File as FileModel;
use Illuminate\Support\Facades\File;

class DeleteAction
{
    /**
     * @param FileModel $files
     */
    public function __construct(
        protected FileModel     $files,
    )
    {
    }

    /**
     * @param int $id
     * @param int $userId
     * @param float $userSize
     * @return float
     */
    public function __invoke(int $id, int $userId, float $userSize): float
    {
        $file = $this->files::whereId($id)
            ->where("user_id", $userId);

        $fileInfo = $file->first();

        $userSize -= $fileInfo->size;

        File::delete($fileInfo->full_path_size);

        $file->delete();
        $this->files->setSharingStatus($id, false);

        return round($userSize, 2);
    }
}
