<?php

namespace App\Http\Controllers\Storage\Api;

use App\Http\Actions\Storage\Api\Share\IsFileInSharingAction;
use App\Http\Actions\Storage\Api\Share\ShareFileAction;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Traits\JsonResponseTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShareController extends Controller
{
    use JsonResponseTrait;

    /**
     * @param Request $request
     * @param ShareFileAction $action
     * @param int $id
     * @return Application|ResponseFactory|Response
     */
    public function shareFile(Request $request, ShareFileAction $action, int $id): Application|ResponseFactory|Response
    {
        return $this->success(data: $action($id));
    }

    /**
     * @param Request $request
     * @param IsFileInSharingAction $action
     * @param int $id
     * @return Application|ResponseFactory|Response
     */
    public function isFileInSharing(Request $request, IsFileInSharingAction $action, int $id): Application|ResponseFactory|Response
    {
        return $this->success(data: $action($id));
    }
}
