<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Actions\Admin\Api\Users\SetBanStatusAction;
use App\Http\Actions\Admin\Api\Users\SetMaxFilesSizeAction;
use App\Http\Actions\Admin\Api\Users\SetRoleAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Api\Users\SetBanStatusRequest;
use App\Http\Requests\Admin\Api\Users\SetMaxFilesSizeRequest;
use App\Http\Requests\Admin\Api\Users\SetRoleRequest;
use App\Traits\JsonResponseTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;


class UsersController extends Controller
{
    use JsonResponseTrait;

    /**
     * @param SetRoleRequest $request
     * @param SetRoleAction $action
     * @param int $id
     * @return Application|ResponseFactory|Response
     */
    public function setRole(SetRoleRequest $request, SetRoleAction $action,int $id)
    {
        $role = $request->validated()["role"];
        $user = $action($id, $role);

        return $this->success(message: "Ok", data: $user);
    }

    /**
     * @param SetBanStatusRequest $request
     * @param SetBanStatusAction $action
     * @param int $id
     * @return Application|ResponseFactory|Response
     */
    public function setBanStatus(SetBanStatusRequest $request, SetBanStatusAction $action, int $id)
    {
        $status = $request->validated()["status"];
        $user = $action($id, $status);

        return $this->success(message: "Ok", data: $user);
    }

    /**
     * @param SetMaxFilesSizeRequest $request
     * @param SetMaxFilesSizeAction $action
     * @param int $id
     * @return Application|ResponseFactory|Response
     */
    public function setMaxFilesSize(SetMaxFilesSizeRequest $request, SetMaxFilesSizeAction $action, int $id)
    {
        $maxFilesSize = (float)$request->validated()["max_size"];
        $user = $action($id, $maxFilesSize);

        return $this->success(message: "Ok", data: $user);
    }

}
