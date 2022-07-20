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
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

// 前台
use App\Http\Controllers\Frontend\WebController as WebController;
use App\Http\Controllers\Frontend\HomeSliderController as HomeSliderController;
use App\Http\Controllers\Frontend\MemberController as MemberController;
use App\Http\Controllers\Frontend\NewsController as NewsController;
use App\Http\Controllers\Frontend\ProductController as ProductController;
use App\Http\Controllers\Frontend\CartController as CartController;
use App\Http\Controllers\Frontend\OrderController as OrderController;
use App\Http\Controllers\Frontend\ContactController as ContactController;

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

        Route::get('/orders', [AdminOrderController::class, 'getItems']);
        Route::get('/orders/{id}', [AdminOrderController::class, 'getItem']);
        Route::put('/orders/{id}', [AdminOrderController::class, 'updateItem']);
        Route::delete('/orders/{id}', [AdminOrderController::class, 'deleteItem']);

        Route::get('/contact', [AdminContactController::class, 'getItems']);
        Route::get('/contact/{id}', [AdminContactController::class, 'getItem']);
        Route::put('/contact/{id}', [AdminContactController::class, 'updateItem']);
        Route::delete('/contact/{id}', [AdminContactController::class, 'deleteItem']);

        // ckeditor 上傳圖片 api
        Route::post('/editor/upload', [AdminEditorController::class, 'upload']);
    });    

    // JWT demo api
    Route::get('/jwt_demo', [JwtDemoController::class, 'jwt_demo']);
});

// 前台
Route::get('/web_data', [WebController::class, 'getData']);

Route::get('/home_sliders', [HomeSliderController::class, 'getItems']);

Route::get('/news', [NewsController::class, 'getItems']);
Route::get('/news/{id}', [NewsController::class, 'getItem']);

Route::get('/product_categories', [ProductController::class, 'getCategories']);
Route::get('/subcategory_products/{subcategory_id}', [ProductController::class, 'getSubcategoryProducts']);
Route::get('/products/{id}', [ProductController::class, 'getItem']);

Route::post('/members', [MemberController::class, 'add']);
Route::post('/login', [MemberController::class, 'login']);
Route::get('/members', [MemberController::class, 'getItem']);
Route::post('/members/checkToken', [MemberController::class, 'checkToken']);

Route::post('/contact', [ContactController::class, 'add']);

Route::post('/orders', [OrderController::class, 'add']);

Route::middleware(['auth.member_api'])->group(function() {
    Route::put('/members', [MemberController::class, 'updateItem']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'getItems']);
    Route::delete('/cart/{id}', [CartController::class, 'deleteItem']);
    Route::put('/cart/{id}', [CartController::class, 'updateItem']);
    Route::get('/orders', [OrderController::class, 'getItems']);
    Route::get('/orders/{id}', [OrderController::class, 'getItem']);
});





