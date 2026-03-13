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
    return view('welcome');
});

Route::get('/prueba', function () {
    return view('test', ['nombre' => 'Aprendiz de Laravel']);
});

Route::get('/dashboard', function () {
    $stores = Auth::user()->stores;
    return view('dashboard', compact('stores'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/stores/orders', [SellerOrderController::class, 'index'])->name('stores.orders.index');
    Route::get('/stores/orders/{order}', [SellerOrderController::class, 'details'])->name('stores.orders.details');
    Route::patch('/stores/orders/{order}/complete', [SellerOrderController::class, 'complete'])->name('stores.orders.complete');
    
    Route::resource('stores', StoreController::class)->only(['create', 'store']);
    Route::resource('stores.categories',CategoryController::class);
    Route::resource('stores.products',ProductController::class);

});

// rutas publicas:
Route::get('/s/{store:slug}',[PublicStoreController::class,'index'])->name('public.store.show');
Route::get('/s/{store:slug}/cart',[CartController::class,'index'])->name('public.cart.show');
Route::get('/s/{store:slug}/checkout',[CheckoutController::class,'index'])->name('public.checkout.index');
Route::post('/s/{store:slug}/checkout',[CheckoutController::class,'process'])->name('public.checkout.process');
Route::get('/s/{store:slug}/{category:slug}',[PublicStoreController::class,'category'])->name('public.store.category');

Route::post('/s/{store:slug}/add-to-cart/{product}',[CartController::class,'add'])->name('public.cart.add');
Route::post('/s/{store:slug}/cart/{product}/decrement',[CartController::class,'decrement'])->name('public.cart.decrement');
Route::delete('/s/{store:slug}/cart/{product}', [CartController::class, 'remove'])->name('public.cart.remove');

require __DIR__.'/auth.php';
