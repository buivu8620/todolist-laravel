<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TaskController;

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

Route::get('/', [ActivityController::class, 'index'])->name('home');

Route::get('/detail/{id}', [TaskController::class, 'getTaskByCategory']);

Route::prefix('activity')->group(function() {
    Route::post('store', [ActivityController::class, 'store']);
    Route::get('delete/{id}', [ActivityController::class, 'destroy']);
    Route::post('update/{id}', [ActivityController::class, 'update']);
});

Route::prefix('task')->group(function() {
    Route::post('store', [TaskController::class, 'store']);
    Route::get('delete/{id}', [TaskController::class, 'destroy']);
    Route::post('update/{id}', [TaskController::class, 'update']);
    
});


// Route::post('/store-activity', [ActivityController::class, 'store']);