<?php

namespace App\DTO\Share;

use App\Interfaces\DTOToArrayInterface;
use App\Models\File;

class FileInfoDTO implements DTOToArrayInterface
{
    /**
     * @param File $file
     * @param mixed $fileExpired
     */
    public function __construct(
        public File  $file,
        public mixed $fileExpired
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'file' => $this->file,
            'fileExpired' => $this->fileExpired,
        ];
    }
}
