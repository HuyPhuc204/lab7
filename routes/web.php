<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
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

Route::get('/',  [OrderController::class, 'index'])->name('list');
Route::get('/add', [OrderController::class, 'create']);
Route::post('/add', [OrderController::class, 'store'])->name('add');
Route::get('/edit/{order}', [OrderController::class, 'edit'])->name('edit');
Route::put('/update/{order}', [OrderController::class, 'update'])->name('update');
Route::delete('/delete/{order}', [OrderController::class, 'destroy'])->name('destroy');
