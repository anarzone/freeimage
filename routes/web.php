<?php

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


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('/saved', [HomeController::class,'getSavedImages'])->name('saved');
Route::get('images/search', [HomeController::class, 'search'])->name('get.images');
Route::post('images/store', [HomeController::class, 'store'])->name('store');

