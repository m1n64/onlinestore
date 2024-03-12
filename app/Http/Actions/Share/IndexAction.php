<?php

namespace App\Http\Actions\Share;

use App\Classes\Constants\Messages;
use App\Classes\Constants\StatusCodes;
use App\DTO\Share\FileInfoDTO;
use App\Models\File;
use Illuminate\Support\Facades\Cache;

class IndexAction
{
    /**
     * @param string $slug
     * @return FileInfoDTO
     */
    public function __invoke(string $slug): FileInfoDTO
    {
        $file = File::with("user")
            ->whereSlug($slug)
            ->first();

        if (is_null($file)) abort(StatusCodes::NOT_FOUND);

        $cacheFileInd = Messages::SHARING_FILES_NAME."--{$file->id}";

        if (!Cache::has($cacheFileInd)) {
            abort(StatusCodes::NOT_FOUND);
        }

        $cacheFile = Cache::get($cacheFileInd);
        if (@$cacheFile["file"] !== $file->slug) {
            abort(StatusCodes::NOT_FOUND);
        }

        return new FileInfoDTO($file, $cacheFile["expired"]);
    }
}
