<?php

namespace App\Http\Controllers\Storage\Api;

use App\Http\Actions\Storage\Api\Files\CreateAction;
use App\Http\Actions\Storage\Api\Files\DeleteAction;
use App\Http\Actions\Storage\Api\Files\RenameAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storage\Api\Files\CreateRequest;
use App\Http\Requests\Storage\Api\Files\RenameRequest;
use App\Traits\JsonResponseTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FilesController extends Controller
{
    use JsonResponseTrait;

    /**
     * @param CreateRequest $request
     * @param CreateAction $action
     * @return Application|ResponseFactory|Response
     */
    public function create(CreateRequest $request, CreateAction $action): Application|ResponseFactory|Response
    {
        return $action($request);
    }

    /**
     * @param RenameRequest $request
     * @param RenameAction $action
     * @param int $id
     * @return Application|ResponseFactory|Response
     */
    public function rename(RenameRequest $request, RenameAction $action, int $id): Application|ResponseFactory|Response
    {
        $userId = $request->user()->id;

        return $this->success(data: $action($id, $userId, $request->name));
    }

    /**
     * @param Request $request
     * @param DeleteAction $action
     * @param int $id
     * @return Application|ResponseFactory|Response
     */
    public function delete(Request $request, DeleteAction $action, int $id): Application|ResponseFactory|Response
    {
        $userSize = $request->user()->files_size;
        $userId = $request->user()->id;

        $userSize = $action($id, $userId, $userSize);

        $request->user()->setFilesSize($userSize);

        return $this->success(message: "Ok", data: ["userSize" => $userSize]);
    }
}
