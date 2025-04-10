<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CatalogController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\WishController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SetLocaleController;
use Illuminate\Support\Facades\Route;

Route::post('/locale', [SetLocaleController::class, 'locale'])->name('locale');

//Shop
Route::get('/', HomeController::class)->name('/');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/navigation', [CatalogController::class, 'navigation'])->name('catalog.navigation.index');
Route::get('/catalog/{section:slug}', [CatalogController::class, 'sectionIndex'])->name('catalog.section.index');
Route::get('/catalog/{section:slug}/category/{category:slug}', [CatalogController::class, 'categoryIndex'])->name('catalog.section.category.index');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

Route::get('/sections', [SectionController::class, 'index'])->name('section.index');
Route::get('/sections/{section}', [SectionController::class, 'show'])->name('section.show');

Route::resource('/product', ProductController::class)->only('show');

Route::middleware(['auth'])->group(function () {

    Route::get('/wishlist', [WishController::class, 'index'])->name('wishlist');
    Route::post('/{product}/toggle', [WishController::class, 'toggle'])->name('wish.toggle');
});
Route::controller(OrderController::class)->group(function () {
    Route::get('/orderlist', 'index')->name('orderlist');
    Route::post('/{order}/pay', 'pay')->name('order.pay');
    Route::delete('/{order}', 'destroy')->name('order.destroy');
})->middleware(['auth']);

//Cart
Route::controller(CartController::class)
    ->prefix('cart')
    ->group(function () {
        Route::get('/', 'index')->name('cart.index');
        Route::post('/order', 'order')->name('cart.order');
        Route::post('/{product}/add', 'add')->name('cart.add');
        Route::patch('/{product}/increase', 'increase')->name('cart.increase');
        Route::patch('/{product}/decrease', 'decrease')->name('cart.decrease');
        Route::delete('/{product}', 'destroy')->name('cart.destroy');
    });

//Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
