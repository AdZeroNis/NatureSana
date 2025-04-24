<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;

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
// 📧 تأیید ایمیل
// ------------------------
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('Auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('home')->with('success', 'ایمیل شما با موفقیت تایید شد');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'لینک تأیید جدید ارسال شد!');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ------------------------
// 🛠️ پنل مدیریت (فقط برای کاربران احراز هویت‌شده و ایمیل‌تأیید‌شده)
// ------------------------
Route::prefix('panel')->middleware(['auth', 'verified'])->group(function () {
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
});
