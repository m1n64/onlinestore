<?php

namespace App\Http\Actions\Storage\Api\Share;

use App\DTO\Storage\Api\Sharing\IsFileInSharingDTO;
use App\Models\File;

class IsFileInSharingAction
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
        return new IsFileInSharingDTO(
            inSharing: $this->files->isFileInSharing($id),
            downloadUrl: $this->files->find($id)->download_link,
        );
    }
}
