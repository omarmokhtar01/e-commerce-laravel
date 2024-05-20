<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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

// Authentication
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth');
    Route::get('/user-profile', [AuthController::class, 'userProfile'])->middleware('auth');    
});

// Brand CRUD
Route::group([
    // 'middleware' => 'DbBackup',
    'prefix' => 'brands'
], function ($router) {
    Route::get('/', [BrandController::class, 'index']);
    Route::get('/{id}', [BrandController::class, 'show']);
    Route::post('/', [BrandController::class, 'store'])->middleware('is_admin');
    Route::put('/{id}', [BrandController::class, 'update'])->middleware('auth');
    Route::delete('/{id}', [BrandController::class, 'destroy'])->middleware('auth');    
});

// Category CRUD
Route::group([
    // 'middleware' => 'DbBackup',
    'prefix' => 'categories'
], function ($router) {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::post('/', [CategoryController::class, 'store'])->middleware('auth');
    Route::put('/{id}', [CategoryController::class, 'update'])->middleware('auth');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware('auth');    
});

// Product CRUD
Route::group([
    // 'middleware' => 'DbBackup',
    'prefix' => 'products'
], function ($router) {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store'])->middleware('auth');
    Route::put('/{id}', [ProductController::class, 'update'])->middleware('auth');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware('auth');    
});

// Location
Route::group([
    // 'middleware' => 'DbBackup',
    'prefix' => 'location'
], function ($router) {
    // Route::get('/', [LocationController::class, 'index']);
    // Route::get('/{id}', [LocationController::class, 'show']);
    Route::post('/', [LocationController::class, 'store'])->middleware('auth');
    Route::put('/{id}', [LocationController::class, 'update'])->middleware('auth');
    Route::delete('/{id}', [LocationController::class, 'destroy'])->middleware('auth');    
});

// Cart
Route::group([
    // 'middleware' => 'DbBackup',
    'prefix' => 'cart'
], function ($router) {
    Route::get('/{id}', [CartController::class, 'show'])->middleware('auth');
    Route::post('/', [CartController::class, 'store'])->middleware('auth');
    Route::put('/{id}', [CartController::class, 'update'])->middleware('auth');
    Route::delete('/{id}', [CartController::class, 'destroy'])->middleware('auth');    
});

// Orders
Route::group([
    // 'middleware' => 'DbBackup',
    'prefix' => 'orders'
], function ($router) {
    Route::get('/', [OrderController::class, 'index']);
    Route::get('/{id}', [OrderController::class, 'show'])->middleware('auth');
    Route::post('/', [OrderController::class, 'store'])->middleware('auth');
    Route::put('/{id}', [OrderController::class, 'update'])->middleware('auth');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->middleware('auth');    
});