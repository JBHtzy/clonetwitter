<?php

use App\Http\Controllers\RoomtypeController;
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
});



// Admin Routes
// Route::resource('admin/roomtype', RoomtypeController::class);
Route::get('/admin/roomtype', [RoomtypeController::class, 'index'])->name('roomtype');
Route::post('/admin/roomtype/store', [RoomtypeController::class, 'store']);
Route::get('/admin/roomtype/{id}', [RoomtypeController::class, 'show']);
Route::put('/admin/roomtype/{id}/edit', [RoomtypeController::class, 'update']);
Route::delete('/admin/roomtype/delete={id}', [RoomtypeController::class, 'destroy']);
