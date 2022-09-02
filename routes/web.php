<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Mail\WelcomeMail;
use App\Events\FormSubmitted;
use App\Notifications\InvoicePaid;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AddCartController;
use App\Http\Controllers\AuthOtpController;
use App\Notifications\RealTimeNotification;
use App\Http\Controllers\CartItemController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\ShopProductController;
use App\Http\Controllers\ProductOrderController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'))->middleware(['auth','verified']);
    }

    return redirect()->route('admin.home');
});

Auth::routes(['verify' => true]);



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home')->middleware('verified');

    //noti
    Route::post('/mark-as-read', 'HomeController@markNotification')->name('markNotification');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Product Category
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::post('product-categories/ckmedia', 'ProductCategoryController@storeCKEditorImages')->name('product-categories.storeCKEditorImages');
    Route::resource('product-categories', 'ProductCategoryController');

    // Product Tag
    Route::delete('product-tags/destroy', 'ProductTagController@massDestroy')->name('product-tags.massDestroy');
    Route::resource('product-tags', 'ProductTagController');

    // Product
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('products/ckmedia', 'ProductController@storeCKEditorImages')->name('products.storeCKEditorImages');
    Route::resource('products', 'ProductController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

// Route::get('products', function() {
//     $products = Product::get();
//     return view('products', compact('products') );
// })->name('products#display');

Route::group(['middleware' => 'auth'], function() {
    Route::get('products', [ShopProductController::class, 'products'])->name('products#dashboard');

    Route::get('store/{id}/{name}/{price}/{fileId}/{file}', [ShopProductController::class, 'store'])->name('product#store');
    Route::get('cart', [CartItemController::class, 'items'])->name('cart#items');
    Route::get('clear', [CartItemController::class, 'clear'])->name('cart#clear');
    Route::get('sort', [ShopProductController::class, 'sort'])->name('product#sort');
    Route::get('wishLIst/{id}/{name}/{price}/{filed}/{file}', [ShopProductController::class, 'wishList'])->name("product#wishList");
    Route::get('wishItems', [CartItemController::class, 'wish'])->name('wish#item');
    Route::get('clearWish', [CartItemController::class, 'clearWish'])->name('clear#wish');
    Route::get('increase/{id}', [CartItemController::class, 'increase'])->name('item#increase');
    Route::get('decrease/{id}', [CartItemController::class, 'decrease'])->name('item#decrease');
    Route::get('remove/{id}', [CartItemController::class, 'remove'])->name('remove#item');
    // Route::get('checkout', [CartItemController::class, 'checkout'])->name('cart#checkout');
    Route::post('order', [CartItemController::class, 'order'])->name('order');

    //order list view
    Route::get('order/list', [OrderController::class, 'orderList'])->name('order#list');
    Route::get('order/detail/{id}', [OrderController::class, 'detail'])->name('order#detail');


    //ajax test
    Route::prefix('ajax')->group(function() {
        Route::get('product/list', [AjaxController::class, 'productList'])->name('product#list');
    });

    //OTP login
    Route::get('otp/login', [AuthOtpController::class, 'login'])->name('otp#login');
    Route::post('otp/get', [AuthOtpController::class, 'generate'])->name('otp#get');
    Route::get('otp/verification/{user_id}', [AuthOtpController::class, 'verification'])->name('otp#verification');
    Route::post('otp/login', [AuthOtpController::class, 'loginWithOtp'])->name('otp#getLogin');


    Route::get('/role', function () {

        $user = Role::where('id', 2)->first()->user;


        return $user;
    });

    //notification
    Route::get('/send-productorder', [ProductOrderController::class, 'sendTestNotification']);

    //route for mailing
    Route::get('/email', [SendEmailController::class, 'sendEmail'])->name('send#email');

});

Route::get('realTimeNoti', function() {

    $admins = User::whereHas('roles', function($query) {
        $query->where('id', 1);
    })->get();


    foreach($admins as $admin) {
    $admin->notify(new RealTimeNotification('this is notification section'));
    }
});


