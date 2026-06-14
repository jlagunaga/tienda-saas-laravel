<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PublicStoreController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Seller\SellerCustomerController;
use App\Http\Controllers\PublicReviewController;
use App\Http\Controllers\Seller\SellerReviewController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\Seller\ContactController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }else{
        return view('auth.login');
    }
});

Route::get('/prueba', function () {
    return view('test', ['nombre' => 'Aprendiz de Laravel']);
});



// guardia de usuarios (vendedores)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [StoreController::class, 'show'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/stores/orders/{store}', [SellerOrderController::class, 'index'])->name('stores.orders.index');
    Route::get('/stores/orders/details/{order}', [SellerOrderController::class, 'details'])->name('stores.orders.details');
    
    Route::get('/stores/message/{store}', [ContactController::class, 'index'])->name('stores.messages.index');
    Route::get('/stores/message/{store}/{message}', [ContactController::class, 'show'])->name('stores.message.show');

    Route::patch('/stores/orders/{order}/complete', [SellerOrderController::class, 'complete'])->name('stores.orders.complete');
    Route::patch('/stores/orders/{order}/cancel', [SellerOrderController::class, 'cancel'])->name('stores.orders.cancel');
    Route::patch('/stores/orders/{order}/confirm-payment', [SellerOrderController::class, 'confirmPayment'])->name('stores.orders.confirm-payment');
    Route::patch('/stores/{store}/reviews/{review}/toggle', [SellerReviewController::class, 'toggleVisibility'])->name('stores.reviews.toggle');
    
    Route::resource('stores', StoreController::class)->only(['create', 'store','edit','update']);
    Route::resource('stores.categories',CategoryController::class);
    Route::resource('stores.products',ProductController::class);

    Route::get('/stores/{store}/customers',[SellerCustomerController::class,'index'])->name('stores.customers.index');
    Route::get('/stores/{store}/customers/{customer}',[SellerCustomerController::class,'show'])->name('stores.customers.show');

});

// guardia de customer
Route::middleware('auth:customer')->group(function () {
    Route::get('/s/{store:slug}/mis-compras',[CustomerDashboardController::class,'index'])->name('public.customer.dashboard');
    Route::get('/s/{store:slug}/mis-compras/{order}',[CustomerDashboardController::class,'show'])->name('public.customer.order');
    Route::put('/s/{store:slug}/perfil',[CustomerDashboardController::class,'updateProfile'])->name('public.customer.profile.update');
    Route::post('/s/{store:slug}/products/{product}/reviews',[PublicReviewController::class,'store'])->name('public.reviews.store');
});



// rutas publicas:
Route::get('/s/{store:slug}',[PublicStoreController::class,'index'])->name('public.store.show');
Route::get('/s/{store:slug}/register',[CustomerAuthController::class,'showRegister'])->name('public.store.register');
Route::get('/s/{store:slug}/login',[CustomerAuthController::class,'showLogin'])->name('public.store.login');
Route::get('/s/{store:slug}/cart',[CartController::class,'index'])->name('public.cart.show');
Route::get('/s/{store:slug}/checkout',[CheckoutController::class,'index'])->name('public.checkout.index');
Route::get('/s/{store:slug}/checkout/success/{order}',[CheckoutController::class,'success'])->name('public.checkout.success');
Route::get('/s/{store:slug}/p{product}',[PublicStoreController::class,'product'])->name('public.store.product')->where('product', '[0-9]+');
Route::get('/s/{store:slug}/{category:slug}',[PublicStoreController::class,'category'])->name('public.store.category');


Route::post('/s/{store:slug}/register',[CustomerAuthController::class,'register'])->name('public.store.register');
Route::post('/s/{store:slug}/contact',[PublicContactController::class,'store'])->name('public.store.contact');
Route::post('/s/{store:slug}/login',[CustomerAuthController::class,'login'])->name('public.store.login');
Route::post('/s/{store:slug}/logout',[CustomerAuthController::class,'logout'])->name('public.store.logout');
Route::post('/s/{store:slug}/checkout',[CheckoutController::class,'process'])->name('public.checkout.process');


Route::post('/s/{store:slug}/add-to-cart/{product}',[CartController::class,'add'])->name('public.cart.add');
Route::post('/s/{store:slug}/cart/{product}/decrement',[CartController::class,'decrement'])->name('public.cart.decrement');
Route::delete('/s/{store:slug}/cart/{product}', [CartController::class, 'remove'])->name('public.cart.remove');

require __DIR__.'/auth.php';
