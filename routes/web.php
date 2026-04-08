<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminAboutSectionController;
use App\Http\Controllers\AdminHomeSectionController;
use App\Http\Controllers\AdminLanguageController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminQuoteController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\AdminSiteSettingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [AboutController::class, 'index'])->name('about.index');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/locale/{language:code}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/quote-request', [QuoteRequestController::class, 'create'])->name('quotes.create');
Route::post('/quote-request', [QuoteRequestController::class, 'store'])->name('quotes.store');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->middleware('admin.permission:dashboard.view')->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');

        Route::resource('products', AdminProductController::class)->except(['show'])->middleware('admin.permission:products.manage');
        Route::resource('home-sections', AdminHomeSectionController::class)->except(['show'])->middleware('admin.permission:home_sections.manage');
        Route::resource('about-sections', AdminAboutSectionController::class)->except(['show'])->parameters(['about-sections' => 'aboutSection'])->middleware('admin.permission:about_sections.manage');
        Route::resource('articles', AdminArticleController::class)->except(['show'])->middleware('admin.permission:articles.manage');
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show'])->middleware('admin.permission:testimonials.manage');
        Route::resource('languages', AdminLanguageController::class)->except(['show'])->middleware('admin.permission:languages.manage');
        Route::resource('roles', AdminRoleController::class)->except(['show'])->middleware('admin.permission:roles.manage');
        Route::resource('users', AdminUserController::class)->except(['show'])->middleware('admin.permission:users.manage');
        Route::get('quotes', [AdminQuoteController::class, 'index'])->middleware('admin.permission:quotes.view')->name('quotes.index');
        Route::get('messages', [AdminMessageController::class, 'index'])->middleware('admin.permission:messages.view')->name('messages.index');
        Route::get('settings', [AdminSiteSettingController::class, 'edit'])->middleware('admin.permission:settings.manage')->name('settings.edit');
        Route::put('settings', [AdminSiteSettingController::class, 'update'])->middleware('admin.permission:settings.manage')->name('settings.update');
    });
});
