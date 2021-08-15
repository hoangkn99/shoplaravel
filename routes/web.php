<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;
//font-end
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu','App\Http\Controllers\HomeController@index');




//back-end
use App\Http\Controllers\AdminController;
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::POST('/admin-dashboard', [AdminController::class, 'dashboard']);

// category-product
use App\Http\Controllers\CategoryProduct;
Route::get('/add-category-product', [CategoryProduct::class, 'add_category_product']); //thêm danh mục sản phẩm
Route::get('/all-category-product', [CategoryProduct::class, 'all_category_product']);// liệt kê danh mục sản phẩm

Route::get('/unactive-category-product/{category_product_id}', [CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProduct::class, 'active_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProduct::class, 'delete_category_product']);

Route::post('/update-category-product/{category_product_id}', [CategoryProduct::class, 'update_category_product']);// cập nhật danh mục

Route::post('/save-category-product', [CategoryProduct::class, 'save_category_product']);// xử lý thêm danh mục
//category_home
Route::get('/danh-muc-san-pham/{category_id}',[CategoryProduct::class, 'show_category_home']);


// Brand-product
use App\Http\Controllers\BrandProduct;
Route::get('/add-brand-product', [BrandProduct::class, 'add_brand_product']); //thêm thương hiệu sản phẩm
Route::get('/all-brand-product', [BrandProduct::class, 'all_brand_product']);// liệt kê thương hiệu sản phẩm

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProduct::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProduct::class, 'active_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProduct::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProduct::class, 'delete_brand_product']);

Route::post('/update-brand-product/{brand_product_id}', [BrandProduct::class, 'update_brand_product']);// cập nhật thương hiệu

Route::post('/save-brand-product', [BrandProduct::class, 'save_brand_product']);// xử lý thêm thương hiệu


//Hiển thị brand index
Route::get('/thuong-hieu-san-pham/{brand_id}',[BrandProduct::class, 'show_brand_home']);


// product
use App\Http\Controllers\ProductController;
Route::get('/add-product', [ProductController::class, 'add_product']); //thêm sản phẩm
Route::get('/all-product', [ProductController::class, 'all_product']);// liệt kê sản phẩm

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);

Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);// cập nhật sản phẩm

Route::post('/save-product', [ProductController::class, 'save_product']);// xử lý thêm sản phẩm

//chi tiet san phẩm
Route::get('/chi-tiet-san-pham/{product_id}',[ProductController::class, 'details_product']);

//giỏ hàng
use App\Http\Controllers\CartController;
Route::post('/save-cart', [CartController::class, 'save_cart']);// xử lý thêm sản phẩm
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);// xử lý thêm sản phẩm
Route::post('/update-cart', [CartController::class, 'update_cart']);// xử lý thêm sản phẩm
Route::get('/gio-hang', [CartController::class, 'gio_hang']);
Route::get('/del-product/{session_id}', [CartController::class, 'del_product']);
Route::get('/del-all-product', [CartController::class, 'del_all_product']);

//checkout

Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);

Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::Post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/payment', [CheckoutController::class, 'payment']);

Route::Post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);

Route::Post('/login-customer', [CheckoutController::class, 'login_customer']);

Route::Post('/order-place', [CheckoutController::class, 'order_place']);


// admin quản lý đơn hàng
Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
Route::get('/view-order/{order_id}', [CheckoutController::class, 'view_order']);

































////use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\HomeController;

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
/*
Route::get('/', function () {
    return view('layout');
});
Route::get('/trang-chu', function () {
    return view('layout');
});

Route::get('/', 'HomeController@index'); //Gọi hàm index từ homecontroller

Route::get('/trang-chu','HomeController@index');
*/
//Route::get('/', [HomeController::class, 'index']);
//Route::get('/trang-chu','App\Http\Controllers\HomeController@index');