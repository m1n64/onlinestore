<?php

namespace App\Http\Controllers\Storage\Api;

use App\Http\Actions\Storage\Api\Folders\CreateAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storage\Api\Folders\CreateRequest;
use App\Models\Folder;
use App\Traits\JsonResponseTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FoldersController extends Controller
{
    use JsonResponseTrait;

    /**
     * @param Folder $folders
     */
    public function __construct(
        protected Folder $folders,
    )
    {}

    /**
     * @param CreateRequest $request
     * @param CreateAction $action
     * @return Application|ResponseFactory|Response
     */
    public function create(CreateRequest $request, CreateAction $action) : Application|ResponseFactory|Response
    {
        [$name, $folderSlug] = array_values($request->validated());
        $userId = $request->user()->id;

        return $this->success(data: $action($name, $folderSlug, $userId));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Application|ResponseFactory|Response
     */
    public function delete(Request $request, int $id) : Application|ResponseFactory|Response
    {
        try {
            $userId = $request->user()->id;
            $this->folders->deleteFolder($id, $userId);

            return $this->success(message: "Ok");
        } catch (\Exception $exception) {
            return $this->error(message: "You are not deleting this folder because there are other folders or files in this folder");
        }
    }
}
