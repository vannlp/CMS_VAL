<?php

use App\Helpers\Menu;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Settings\PermissionController;
use App\Http\Controllers\Settings\SettingController;
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
});
Route::get("/admin/login", [LoginController::class, 'loginAdmin'])->name("admin.login");
Route::post("/admin/handle-login", [LoginController::class, 'handleLoginAdmin'])->name("admin.handleLoginAdmin");

