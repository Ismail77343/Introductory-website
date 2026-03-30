<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminAboutSectionController;
use App\Http\Controllers\AdminHomeSectionController;
use App\Http\Controllers\AdminLanguageController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminQuoteController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\AdminSiteSettingController;
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
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('home-sections', AdminHomeSectionController::class)->except(['show']);
    Route::resource('about-sections', AdminAboutSectionController::class)->except(['show'])->parameters(['about-sections' => 'aboutSection']);
    Route::resource('articles', AdminArticleController::class)->except(['show']);
    Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
    Route::resource('languages', AdminLanguageController::class)->except(['show']);
    Route::get('quotes', [AdminQuoteController::class, 'index'])->name('quotes.index');
    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
    });
});
