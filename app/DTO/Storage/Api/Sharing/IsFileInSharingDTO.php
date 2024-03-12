<?php

namespace App\DTO\Storage\Api\Sharing;

class IsFileInSharingDTO
{
    /**
     * @param bool $inSharing
     * @param string $downloadUrl
     */
    public function __construct(
        public bool $inSharing,
        public string $downloadUrl,
    )
    {
    }
}
