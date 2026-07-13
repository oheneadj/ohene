<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/work', [WorkController::class, 'index'])->name('work.index');
Route::get('/work/{project}', [WorkController::class, 'show'])->name('work.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}/preview', [BlogController::class, 'preview'])->name('blog.preview');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/videos', [PageController::class, 'videos'])->name('videos');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/rss.xml', [FeedController::class, 'blog'])->name('rss');
