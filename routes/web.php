<?php

use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SubscriptionPackageController;
use App\Http\Controllers\SubscriptionPackageBookController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/category/{id}', [HomeController::class, 'category'])->name('category.show');
Route::get('/kategori/{id}', [HomeController::class, 'category']);

Route::middleware(['IsLoggedIn'])->group(function(){
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware('IsAdmin')->group(function(){
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('book-categories', BookCategoryController::class);
        Route::get('paket-langganan/books/{id}', [SubscriptionPackageBookController::class, 'show'])->name('paket-langganan.books');
        Route::post('paket-langganans/books/{id}', [SubscriptionPackageBookController::class, 'store'])->name('paket-langganan.books.store');
        Route::resource('paket-langganan', SubscriptionPackageController::class);
        Route::resource('books', BookController::class);

    });
});

Route::middleware(['IsGuest'])->group(function(){
    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::post('/register', [UserController::class, 'register'])->name('register.store')
    ->middleware('throttle:5,1');

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'login'])->name('login.store')
    ->middleware('throttle:5,1');
});
