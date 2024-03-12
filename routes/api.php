<?php

use App\Http\Controllers\Admin\Api\UsersController;
use App\Http\Controllers\Storage\Api\FilesController;
use App\Http\Controllers\Storage\Api\FoldersController;
use App\Http\Controllers\Storage\Api\ShareController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["prefix" => "admin", "middleware" => ["auth:sanctum", "is.admin", "is.banned"]], function (){
    Route::post("/setRole/{id}", [UsersController::class, "setRole"])->name("api.admin.set.role");
    Route::post("/setBanStatus/{id}", [UsersController::class, "setBanStatus"])->name("api.admin.set.banstatus");
    Route::post("/setMaxFilesSize/{id}", [UsersController::class, "setMaxFilesSize"])->name("api.admin.set.maxfilessize");
});

Route::group(["prefix" => "folders", "middleware" => ["auth:sanctum", "is.banned"]], function (){
    Route::post("/create", [FoldersController::class, "create"])->name("api.folder.create");
    Route::delete("/delete/{id}", [FoldersController::class, "delete"])->name("api.folder.delete");
});

Route::group(["prefix" => "files", "middleware" => ["auth:sanctum", "is.banned"]], function (){
    Route::post("/create", [FilesController::class, "create"])->name("api.file.create");
    Route::post("/rename/{id}", [FilesController::class, "rename"])->name("api.file.rename");
    Route::delete("/delete/{id}", [FilesController::class, "delete"])->name("api.file.delete");
});

Route::group(["prefix" => "share", "middleware" => ["auth:sanctum", "is.banned"]], function () {
    Route::post("/{id}", [ShareController::class, "shareFile"])->name("api.share.share");
    Route::get("/isShared/{id}", [ShareController::class, "isFileInSharing"])->name("api.share.isShared");
});
