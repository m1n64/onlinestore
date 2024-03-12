<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    /**
     * @param User $users
     */
    public function __construct(
        protected User $users,
    ) {}

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) : Response
    {
        return Inertia::render("Admin/Users", [
            'users' => $this->users->all(),
        ]);
    }
}
