<?php

// 後台
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductCategoryController as AdminProductCategoryController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\HomeSliderController as AdminHomeSliderController;
use App\Http\Controllers\Admin\HeadImgController as AdminHeadImgController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\EditorController as AdminEditorController;

// 前台
use App\Http\Controllers\Frontend\WebController as WebController;
use App\Http\Controllers\Frontend\NewsController as NewsController;

// 測試
use App\Http\Controllers\JwtDemoController as JwtDemoController;

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
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::post('/checkToken', [AdminLoginController::class, 'checkToken']);

    Route::middleware(['auth.admin_api'])->group(function() {
        Route::post('/members', [AdminMemberController::class, 'add']);
        Route::get('/members', [AdminMemberController::class, 'getMemberList']);
        Route::get('/members/{id}', [AdminMemberController::class, 'getMember']);
        Route::put('/members/{id}', [AdminMemberController::class, 'updateMember']);
        Route::delete('/members/{id}', [AdminMemberController::class, 'deleteMember']);
    
        Route::post('/products', [AdminProductController::class, 'add']);
        Route::get('/products', [AdminProductController::class, 'getProductList']);
        Route::get('/products/{id}', [AdminProductController::class, 'getProduct']);
        Route::put('/products/{id}', [AdminProductController::class, 'updateProduct']);
        Route::delete('/products/{id}', [AdminProductController::class, 'deleteProduct']);
    
        Route::post('/product_category', [AdminProductCategoryController::class, 'add']);
        Route::get('/product_category', [AdminProductCategoryController::class, 'getProductCategories']);
        Route::get('/product_category/{id}', [AdminProductCategoryController::class, 'getProductCategory']);
        Route::put('/product_category/{id}', [AdminProductCategoryController::class, 'updateProductCategory']);
        Route::delete('/product_category/{id}', [AdminProductCategoryController::class, 'deleteProductCategory']);
    
        Route::post('/news', [AdminNewsController::class, 'addItem']);
        Route::get('/news', [AdminNewsController::class, 'getItems']);
        Route::get('/news/{id}', [AdminNewsController::class, 'getItem']);
        Route::put('/news/{id}', [AdminNewsController::class, 'updateItem']);
        Route::delete('/news/{id}', [AdminNewsController::class, 'deleteItem']);
    
        Route::post('/home_slider', [AdminHomeSliderController::class, 'addItem']);
        Route::get('/home_slider', [AdminHomeSliderController::class, 'getItems']);
        Route::get('/home_slider/{id}', [AdminHomeSliderController::class, 'getItem']);
        Route::put('/home_slider/{id}', [AdminHomeSliderController::class, 'updateItem']);
        Route::delete('/home_slider/{id}', [AdminHomeSliderController::class, 'deleteItem']);
    
        Route::get('/head_img', [AdminHeadImgController::class, 'getItems']);
        Route::get('/head_img/{id}', [AdminHeadImgController::class, 'getItem']);
        Route::put('/head_img/{id}', [AdminHeadImgController::class, 'updateItem']);
    
        Route::get('/about', [AdminPageController::class, 'getAbout']);
        Route::put('/about', [AdminPageController::class, 'updateAbout']);
    
        // ckeditor 上傳圖片 api
        Route::post('/editor/upload', [AdminEditorController::class, 'upload']);
    });    

    // JWT demo api
    Route::get('/jwt_demo', [JwtDemoController::class, 'jwt_demo']);
});



// 前台
Route::get('/web_data', [WebController::class, 'getData']);
Route::get('/news', [NewsController::class, 'getItems']);


