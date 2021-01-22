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
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Records;
use App\Http\Controllers\Reports;

// reports
Route::get('/reports', [Reports::class, 'index'])->middleware(['auth'])->name('reports');

// records
Route::get('/records', [Records::class, 'index'])->middleware(['auth'])->name('records');
Route::get('/searchOnInput', [Records::class, 'searchOnInput'])->middleware(['auth'])->name('searchOnInput');
Route::get('/tableSearchByDate', [Records::class, 'tableSearchByDate'])->middleware(['auth'])->name('tableSearchByDate');
Route::get('/confirmPassword', [Records::class, 'confirmPassword'])->name('confirmPassword');
Route::post('/confirmPassword', [Records::class, 'confirmPassword'])->name('confirmPassword2');
Route::post('/insertRecord', [Records::class, 'insertRecord'])->middleware(['auth'])->name('insertRecord');
Route::post('/updateRecord', [Records::class, 'updateRecord'])->middleware(['auth'])->name('updateRecord');
Route::post('/deleteRecord', [Records::class, 'deleteRecord'])->middleware(['auth'])->name('deleteRecord');
//middlewares
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
Route::get('/dashboard', [Dashboard::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
