<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\BannedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\StartupController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get("/hui", function () {
    return array_map(fn ($dir) => [$dir => array_map(fn($file) => ['file' => $file, 'url' => Storage::url($file)], Storage::files($dir))], Storage::directories());
});

Route::get('/', [StartupController::class, "index"])->name("startup");

Route::get('/banned', [BannedController::class, "index"])->name("banned");

Route::get('/main/{folderSlug?}', [DashboardController::class, "index"])->middleware(['auth', 'verified', 'is.banned'])->name('dashboard');

Route::get('/share/{slug}', [ShareController::class, "index"])->name("share");

Route::get('/admin/users', [UsersController::class, "index"])->middleware(["is.admin", 'is.banned'])->name("admin.users");

Route::middleware(['auth', 'is.banned'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
