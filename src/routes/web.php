<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\FilmController;
use App\Http\Controllers\Admin\ApiController;

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

Route::get('/', [ApiController::class, 'index']);
Route::get('/films', [FilmController::class, 'index']);


Route::prefix('admin')->middleware(['auth', 'auth.isAdmin'])->name('admin.')->group( function (){
    Route::resource('/users', UserController::class);

});
