<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::any('/change-password', [App\Http\Controllers\HomeController::class, 'changepassword'])->name('change.password');
Route::post('/update-password', [App\Http\Controllers\HomeController::class, 'updatepassword'])->name('update.password');

Route::get('/add-category', [App\Http\Controllers\CategoryController::class, 'addcategory'])->name('add.category');
Route::post('/insert-category', [App\Http\Controllers\CategoryController::class, 'insertcategory'])->name('insert.category');
Route::get('/edit-category/{id}', [App\Http\Controllers\CategoryController::class, 'editcategory'])->name('edit.category');
Route::post('/update-category', [App\Http\Controllers\CategoryController::class, 'updatecategory'])->name('update.category');
Route::post('/delete-category', [App\Http\Controllers\CategoryController::class, 'deletecategory'])->name('delete.category');


Route::get('/add-sub-category', [App\Http\Controllers\CategoryController::class, 'addsubcategory'])->name('add.sub_category');
Route::post('/insert-sub-category', [App\Http\Controllers\CategoryController::class, 'insertsubcategory'])->name('insert.sub_category');
Route::get('/edit-sub-category/{id}', [App\Http\Controllers\CategoryController::class, 'editsubcategory'])->name('edit.sub_category');
Route::post('/update-sub-category', [App\Http\Controllers\CategoryController::class, 'updatesubcategory'])->name('update.sub_category');
Route::post('/delete-sub-category', [App\Http\Controllers\CategoryController::class, 'deletesubcategory'])->name('delete.sub_category');

Route::post('/get-subcategory', [App\Http\Controllers\ProductController::class, 'getsubcategory'])->name('get.subcategory');

Route::get('/add-product', [App\Http\Controllers\ProductController::class, 'addproduct'])->name('add.product');
Route::post('/insert-product', [App\Http\Controllers\ProductController::class, 'insertproduct'])->name('insert.product');
Route::get('/edit-product/{id}', [App\Http\Controllers\ProductController::class, 'editproduct'])->name('edit.product');
Route::post('/update-product', [App\Http\Controllers\ProductController::class, 'updateproduct'])->name('update.product');
Route::post('/delete-product', [App\Http\Controllers\ProductController::class, 'deleteproduct'])->name('delete.product');
