<?php

use App\Helpers\Menu;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\SettingController;
use App\Http\Controllers\Story\StoryCategoryController;
use App\Http\Controllers\Story\StoryController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix("/admin")->name("admin.")->middleware('auth.admin')->group(function() {
    Route::get("/", function () {
        return view("pages.dashboard");
    });
    
    Route::prefix("/user")->name("user.")->group(function() {
        Route::get("/", [UserController::class, "index"])->name('index');
        Route::post('/create', [UserController::class, 'create'])->name('create');
        Route::get("/datatable", [UserController::class, 'datatable'])->name('datatable');
        Route::get('/get-one/{id}', [UserController::class, 'getOne'])->name('getOne');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    });
    
    Route::prefix("/settings")->name("settings.")->group(function() {
        Route::prefix("/permission")->name("permission.")->group(function() {
            Route::get("/", [PermissionController::class, "index"])->name('index');
            Route::get("/get-permissions", [PermissionController::class, "getPermissionByUser"])->name('getPermissionByUser');
            Route::get("/datatable", [PermissionController::class, 'datatable'])->name('datatable');
        });
        
        Route::prefix("/role")->name("role.")->group(function() {
            Route::post("/create", [PermissionController::class, "createRole"])->name('createRole');
            Route::get("/get-role/{id}", [PermissionController::class, "getRole"])->name('getRole');
            Route::post("/update-role/{id}", [PermissionController::class, "updateRole"])->name('updateRole');
        });
    });
    
    Route::prefix("/story")->group(function() {
        Route::get('/category', [StoryCategoryController::class, "index"])->name('story.category');
        Route::get('/category/datatable', [StoryCategoryController::class, "datatable"])->name('story.category.datatable');
        Route::post('/category/create', [StoryCategoryController::class, "createStoryCategory"])->name('story.category.create');
        Route::get('/category/getOne/{id}', [StoryCategoryController::class, "getOne"])->name('story.category.getOne');
        Route::put('/category/update/{id}', [StoryCategoryController::class, "update"])->name('story.category.update');
        Route::delete('/category/delete/{id}', [StoryCategoryController::class, "delete"])->name('story.category.delete');
        
        // Truyện
        Route::get("/", [StoryController::class, "index"])->name('story.index');
        Route::get("/datatable", [StoryController::class, "datatable"])->name('story.datatable');
        Route::get("/create", [StoryController::class, "create"])->name('story.create');
        Route::post("/store", [StoryController::class, "store"])->name('story.store');
    });
});
Route::get("/admin/login", [LoginController::class, 'loginAdmin'])->name("admin.login");
Route::post("/admin/handle-login", [LoginController::class, 'handleLoginAdmin'])->name("admin.handleLoginAdmin");

