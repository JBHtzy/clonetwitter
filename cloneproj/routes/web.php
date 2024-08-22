<?php

use App\Http\Controllers\RoomtypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Login Routes
Route::get('/admin', function () {
    return view('admin-pov.dashboard');
})->name('adminhome');



// Admin Routes
// Route::resource('admin/roomtype', RoomtypeController::class);
Route::prefix('admin')->group(function () {
    Route::get('/roomtype', [RoomtypeController::class, 'index'])->name('roomtype');
    Route::post('/roomtype/store', [RoomtypeController::class, 'store']);
    Route::get('/roomtype/{id}', [RoomtypeController::class, 'show']);
    Route::put('/roomtype/{id}/edit', [RoomtypeController::class, 'update']);
    Route::delete('/roomtype/delete={id}', [RoomtypeController::class, 'destroy']);

    Route::resource('/room', RoomController::class);
    Route::resource('/customer', CustomerController::class);
});
