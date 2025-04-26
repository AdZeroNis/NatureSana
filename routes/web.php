<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Middleware\AdminAccess;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ------------------------
// 🏠 روت‌های عمومی (صفحه اصلی و نمایش محصولات و مقالات)
// ------------------------
Route::namespace("home")->group(function () {
    Route::get('/', [HomeController::class, "home"])->name('home');
    Route::get('/product/{id}', [HomeController::class, "showProduct"])->name('product.show');
    Route::get('/category/{id}/products', [HomeController::class, 'showCategoryProducts'])->name('category.products');
    Route::get('/store/{id}/products', [HomeController::class, 'showStoreProducts'])->name('store.products');
    Route::get('/articles', [HomeController::class, "listArticles"])->name('article.index');
    Route::get('/articles/{id}', [HomeController::class, "showArticle"])->name('article.show');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::post('/store/register', [StoreController::class, 'create'])->name('store.register');
    Route::get('/stores', [StoreController::class, 'index'])->name('store.index');
    
});

// ------------------------
//  احراز هویت
// ------------------------
Route::namespace("auth")->group(function () {
    // ثبت‌نام
    Route::get('/register', [AuthController::class, "showRegisterForm"])->name('register.form');
    Route::post('/register', [AuthController::class, "register"])->name('register.submit');

    // ورود
    Route::get('/login', [AuthController::class, "showLoginForm"])->name('login');
    Route::post('/login', [AuthController::class, "login"])->name('login.submit');

    // خروج
    Route::post('/logout', [AuthController::class, "logout"])->name('logout');
});

// ------------------------
// 📧 تأیید کد
// ------------------------
Route::middleware('auth')->group(function () {
    Route::get('/verify-code', [AuthController::class, 'showVerificationForm'])->name('verification.notice');
    Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verification.verify-code');
    Route::post('/resend-code', [AuthController::class, 'resendCode'])
        ->middleware('throttle:6,1')
        ->name('verification.resend-code');
});

// ------------------------
// 🛠️ پنل مدیریت (فقط برای کاربران احراز هویت‌شده و ایمیل‌تأیید‌شده)
// ------------------------
Route::prefix('panel')->middleware(['auth', AdminAccess::class])->group(function () {
    // داشبورد
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('panel.dashboard.index');


    // دسته‌بندی‌ها
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('panel.category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('panel.category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('panel.category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('panel.category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('panel.category.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('panel.category.delete');
        Route::get('/search', [CategoryController::class, 'filter'])->name('panel.category.filter');
    });

    Route::prefix('store')->group(function () {
        Route::post('/stores/{id}/approve', [StoreController::class, 'approve'])->name('store.approve');
        Route::post('/stores/{id}/reject', [StoreController::class, 'reject'])->name('store.reject');
        Route::get('/edit/{id}', [StoreController::class, "edit"])->name('store.edit');
        Route::post('/update/{id}', [StoreController::class, "update"])->name('store.update');
        Route::get('/show/{id}', [StoreController::class, "show"])->name('store.show');
        Route::delete('/delete/{id}', [StoreController::class, 'destroy'])->name('store.delete');
        Route::get('/search', [StoreController::class, 'filter'])->name('store.filter');
    }); 

});
