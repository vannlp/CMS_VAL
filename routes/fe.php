<?php

use App\Http\Controllers\FE\HomeController;
use App\Http\Controllers\FE\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/truyen/{slug}', [PageController::class, 'detail'])->name('detailPage');
Route::get('/get-hot-post-by-category/{category_id}', [HomeController::class, 'getStoryHtml'])->name('getStoryHtml');
Route::get('/danh-muc/{slug}', [PageController::class, 'categoryPage'])->name('categoryPage');
Route::get('/{slugStory}/{slugChapter}', [PageController::class, 'detailChapter'])->name('detailChapter');