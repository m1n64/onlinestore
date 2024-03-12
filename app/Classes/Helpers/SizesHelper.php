<?php

namespace App\Classes\Helpers;

use App\Interfaces\HelperInterface;

class SizesHelper implements HelperInterface
{
    /**
     * @param int $bytes
     * @return float
     */
    public static function convertBytesToMb(int $bytes) : float
    {
        return round($bytes / 1024 / 1024, 4);
    }
}
