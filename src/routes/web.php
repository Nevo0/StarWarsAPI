<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\FilmController;
use App\Http\Controllers\User\PlanetController;
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
Route::get('/panel', [ApiController::class, 'indexUser'])->middleware('auth')->name('panel');
Route::get('/panel/edit/{id}', [ApiController::class, 'edit'])->middleware('auth')->name('users.edit');
Route::PATCH('/panel/update{id}', [ApiController::class, 'update'])->middleware('auth')->name('users.update');
Route::get('/film/{id}', [FilmController::class, 'show'])->middleware(['auth', 'user.can.url'])->name('showfilm');
Route::get('/planet/{id}', [PlanetController::class, 'show'])->middleware(['auth','user.can.plan'])->name('showplanet');


Route::prefix('admin')->middleware(['auth', 'auth.isAdmin'])->name('admin.')->group( function (){
    Route::resource('/users', UserController::class);

});
