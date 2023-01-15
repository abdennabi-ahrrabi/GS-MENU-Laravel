<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api'
], function ($router) {
    
    /**
     * Authentication Module
     */
    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [UserController::class, 'register']);
        Route::post('login', [UserController::class, 'login']);
        Route::post('logout', [UserController::class, 'logout']);
        Route::post('refresh', [UserController::class, 'refresh']);
        Route::get('me', [UserController::class, 'me']);
    });
    
});

Route::prefix('admins')->name('admins.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/register', [AdminController::class, 'register'])->name('register');
    Route::post('/login', [AdminController::class, 'login'])->name('login');
    Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
    Route::put('/update/{admin}', [AdminController::class, 'update'])->name('update');
    Route::delete('/delete/{admin}', [AdminController::class, 'delete'])->name('destroy');
});

Route::prefix('restaurants')->name('restaurants.')->group(function () {
    Route::get('/', [RestaurantController::class, 'index'])->name('index');
    Route::get('/all', [RestaurantController::class, 'indexAll'])->name('indexAll');
    Route::get('/search', [RestaurantController::class, 'search'])->name('search');
    Route::post('/store', [RestaurantController::class, 'store'])->name('store');
    Route::get('/show/{id}', [RestaurantController::class, 'show'])->name('show');
    Route::put('/update/{id}', [RestaurantController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [RestaurantController::class, 'delete'])->name('destroy');
    });

Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/all', [ProductController::class, 'indexAll'])->name('indexAll');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/show/{id}', [ProductController::class, 'show'])->name('show');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('destroy');
    });

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/all', [CategoryController::class, 'indexAll'])->name('indexAll');
    Route::get('/search', [CategoryController::class, 'search'])->name('search');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
    Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('destroy');
    });

Route::prefix('subcategories')->name('subcategories.')->group(function () {
    Route::get('/', [SubCategoryController::class, 'index'])->name('index');
    Route::get('/all', [SubCategoryController::class, 'indexAll'])->name('indexAll');
    Route::get('/search', [SubCategoryController::class, 'search'])->name('search');
    Route::post('/store', [SubCategoryController::class, 'store'])->name('store');
    Route::get('/show/{id}', [SubCategoryController::class, 'show'])->name('show');
    Route::put('/update/{id}', [SubCategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [SubCategoryController::class, 'delete'])->name('destroy');
    });


Route::post('/admin/login', 'AdminAuthController@login');

    