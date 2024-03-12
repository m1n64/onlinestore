<?php

namespace App\Http\Controllers;

use App\Http\Actions\Share\IndexAction;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShareController extends Controller
{

    /**
     * @param Request $request
     * @param IndexAction $action
     * @param string $slug
     * @return Response
     */
    public function index(Request $request, IndexAction $action, string $slug): Response
    {
        $file = $action($slug);

        return Inertia::render("Share", $file->toArray());
    }
}
