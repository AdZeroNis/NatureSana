<?php
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('panel')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('panel.dashboard.index');

    // مسیرهای مربوط به دسته‌بندی
    Route::prefix('category')->group(function () {
        Route::get('/category-list', [CategoryController::class, 'index'])->name('panel.category.index');
        Route::get('/category-create', [CategoryController::class, 'create'])->name('panel.category.create');
        Route::post('/category-store', [CategoryController::class, 'store'])->name('panel.category.store');
        Route::get('/category-edit/{id}', [CategoryController::class, 'edit'])->name('panel.category.edit');
        Route::post('/category-update/{id}', [CategoryController::class, 'update'])->name('panel.category.update');
        Route::delete('/category-delete/{id}', [CategoryController::class, 'destroy'])->name('panel.category.delete');
        Route::get('/search-category', [CategoryController::class, 'filter'])->name('panel.category.filter');
    });
});
