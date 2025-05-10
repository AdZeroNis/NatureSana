<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Home\ProductCommentController;
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
    // All routes require authentication and verification
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [HomeController::class, "home"])->name('home');
        Route::get('/search', [HomeController::class, 'search'])->name('search');
        Route::get('/articles', [HomeController::class, "articles"])->name('article.index');
        Route::get('/articles/{id}', [HomeController::class, "showArticle"])->name('article.show');
        Route::get('/stores', [StoreController::class, 'index'])->name('store.index');
        Route::get('/product/{id}', [HomeController::class, "showProduct"])->name('product.show');
        Route::get('/category/{id}/products', [HomeController::class, 'showCategoryProducts'])->name('category.products');
        Route::get('/store/{id}/products', [HomeController::class, 'showStoreProducts'])->name('store.products');
        Route::post('/store/register', [StoreController::class, 'create'])->name('store.register');
        
        // نظرات محصولات
        Route::post('/product/{product}/comment', [ProductCommentController::class, 'store'])->name('product.comment.store');
        Route::post('/comment/{comment}/reply', [ProductCommentController::class, 'reply'])->name('product.comment.reply');
    });
});

// ------------------------
//  احراز هویت
// ------------------------
Route::prefix('auth')->group(function () {
    // ثبت‌نام
    Route::get('/register', [AuthController::class, "showRegisterForm"])->name('register.form');
    Route::post('/register', [AuthController::class, "register"])->name('register.submit');

    // ورود
    
    Route::get('/login', [AuthController::class, "showLoginForm"])->name('login');
    Route::post('/login', [AuthController::class, "login"])->name('login.submit');

    // خروج
    Route::get('/logout', [AuthController::class, "logout"])->name('logout');

    // ریست رمز عبور
    Route::prefix('password')->group(function () {

        Route::get('/reset', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
        Route::post('/email', [PasswordResetController::class, 'sendResetCode'])->name('password.email');
        Route::get('/verify', [PasswordResetController::class, 'showVerifyForm'])->name('password.verify');
        Route::post('/verify', [PasswordResetController::class, 'verifyCode'])->name('password.verify.submit');
        Route::get('/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
        Route::post('/reset', [PasswordResetController::class, 'reset'])->name('password.update');
    });

    // ✅ مسیرهایی که نیاز به احراز هویت دارند
    Route::middleware('auth')->group(function () {
        Route::get('/verify-code', [AuthController::class, 'showVerificationForm'])->name('verification.notice');
        Route::post('/verify-code', [AuthController::class, 'verifyCode'])->name('verification.verify-code');
        Route::post('/resend-code', [AuthController::class, 'resendCode'])
            ->middleware('throttle:6,1')
            ->name('verification.resend-code');
    });
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/edit-profile', [AuthController::class, 'edit'])->name('edit.profile');
    Route::post('/edit-profile', [AuthController::class, 'update'])->name('edit.profile.submit');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');
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

    // محصولات
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('panel.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('panel.product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('panel.product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('panel.product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('panel.product.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('panel.product.delete');
        Route::get('/search', [ProductController::class, 'filter'])->name('panel.product.filter');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('panel.product.show');
        Route::get('/get-categories-by-store/{store_id}', [ProductController::class, 'getByStore']);

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
    Route::prefix('article')->group(function () {
        Route::get('/', [ArticleController::class, 'index'])->name('panel.article.index');
        Route::get('/create', [ArticleController::class, 'create'])->name('panel.article.create');
        Route::post('/store', [ArticleController::class, 'store'])->name('panel.article.store');
        Route::get('/edit/{id}', [ArticleController::class, 'edit'])->name('panel.article.edit');
        Route::post('/update/{id}', [ArticleController::class, 'update'])->name('panel.article.update');
        Route::delete('/delete/{id}', [ArticleController::class, 'destroy'])->name('panel.article.delete');
        Route::get('/search', [ArticleController::class, 'filter'])->name('panel.article.filter');
        Route::get('/show/{id}', [ArticleController::class, 'show'])->name('panel.article.show');
    });
    Route::prefix('slider')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('panel.slider.index');
        Route::get('/create', [SliderController::class, 'create'])->name('panel.slider.create');
        Route::post('/store', [SliderController::class, 'store'])->name('panel.slider.store');
        Route::delete('/delete/{id}', [SliderController::class, 'destroy'])->name('panel.slider.delete');
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('panel.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('panel.user.create');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('panel.user.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('panel.user.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('panel.user.delete');
        Route::get('/search', [UserController::class, 'filter'])->name('panel.user.filter');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('panel.user.show');
    });
    Route::prefix('comment')->group(function () {
        Route::get('/', [ProductCommentController::class, 'index'])->name('panel.comment.index');
        Route::delete('/delete/{id}', [ProductCommentController::class, 'destroy'])->name('panel.comment.delete');
        Route::post('/reply/{comment}', [ProductCommentController::class, 'reply'])->name('panel.comment.reply');
        Route::get('/show/{id}', [ProductCommentController::class, 'show'])->name('panel.comment.show');
    });

});
