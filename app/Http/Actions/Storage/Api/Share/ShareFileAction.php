<?php

namespace App\Http\Actions\Storage\Api\Share;

use App\DTO\Storage\Api\Sharing\IsFileInSharingDTO;
use App\Models\File;

class ShareFileAction
{
    /**
     * @param File $files
     */
    public function __construct(
        protected File $files,
    )
    {
    }

    /**
     * @param int $id
     * @return IsFileInSharingDTO
     */
    public function __invoke(int $id): IsFileInSharingDTO
    {
        $this->files->setSharingStatus($id);
        return (new IsFileInSharingAction($this->files))($id);
    }
}
