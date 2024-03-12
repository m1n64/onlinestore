<?php

namespace App\Http\Controllers;

use App\Http\Actions\Dashboard\IndexAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * @param Request $request
     * @param IndexAction $action
     * @param string|null $folderSlug
     * @return Response
     */
    public function index(Request $request, IndexAction $action, string $folderSlug = null) : Response
    {
        $userId = $request->user()->id;
        $dto = $action($userId, $folderSlug);

        return Inertia::render("Dashboard", $dto->toArray());
    }
}
