<?php

namespace App\Classes;

use Illuminate\Support\Facades\Log;

class AdminLog
{
    /**
     * @param $data
     * @return void
     */
    public static function info($data): void
    {
        Log::channel('admin')->info($data);
    }
}
