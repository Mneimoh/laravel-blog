<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\CategoyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GalleryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\WebsiteController::class, 'index'])->name('index');
Route::get('category/{slug}', [App\Http\Controllers\WebsiteController::class, 'category'])->name('category');
Route::get('post/{slug}', [App\Http\Controllers\WebsiteController::class, 'post'])->name('post');
Route::get('page/{slug}', [App\Http\Controllers\WebsiteController::class, 'page'])->name('page');
Route::get('contactme', [App\Http\Controllers\WebsiteController::class, 'showContactForm'])->name('contact.show');
Route::get('contact', [App\Http\Controllers\WebsiteController::class, 'submitContactForm'])->name('contact.submit');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::resource('categories', 'App\Http\Controllers\CategoryController');
    Route::resource('posts', 'App\Http\Controllers\PostController');
    Route::resource('pages', 'App\Http\Controllers\PageController');
    Route::resource('galleries', 'App\Http\Controllers\GalleryController');

});

