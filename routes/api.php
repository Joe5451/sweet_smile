<?php

// 後台
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\EditorController as AdminEditorController;

// 測試
use App\Http\Controllers\Admin\TestController as AdminTestController;

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

// 管理後台
Route::prefix('admin')->group(function() {
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::get('/login', [AdminLoginController::class, 'test']);

    Route::post('/members', [AdminMemberController::class, 'add']);
    Route::get('/members', [AdminMemberController::class, 'getMemberList']);
    Route::get('/members/{id}', [AdminMemberController::class, 'getMember']);
    Route::put('/members/{id}', [AdminMemberController::class, 'updateMember']);
    Route::delete('/members/{id}', [AdminMemberController::class, 'deleteMember']);

    Route::post('/products', [AdminProductController::class, 'add']);
    Route::get('/products', [AdminProductController::class, 'getProductList']);
    Route::get('/products/{id}', [AdminProductController::class, 'getProduct']);
    Route::put('/products/{id}', [AdminProductController::class, 'updateProduct']);
    // Route::delete('/products/{id}', [AdminProductController::class, 'deleteProduct']);

    Route::post('/news', [AdminNewsController::class, 'add']);
    Route::get('/news', [AdminNewsController::class, 'getNewsList']);
    Route::get('/news/{id}', [AdminNewsController::class, 'getNews']);
    Route::put('/news/{id}', [AdminNewsController::class, 'updateNews']);
    // Route::delete('/news/{id}', [AdminNewsController::class, 'deleteNews']);

    Route::get('/about', [AdminPageController::class, 'getAbout']);
    Route::put('/about', [AdminPageController::class, 'updateAbout']);

    // ckeditor 上傳圖片 api
    Route::post('/editor/upload', [AdminEditorController::class, 'upload']);

    Route::post('/upload_file', [AdminTestController::class, 'test'])->name('test');
});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
