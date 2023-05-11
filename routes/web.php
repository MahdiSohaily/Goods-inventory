<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\GoodController;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => false,
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Search Page related routs
    Route::controller(SearchController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard'); // Dashboard route lead us to the search page
        Route::post('/search', 'search')->name('search'); // Route to manage searched path
        Route::get('/mobis/{mobis}', 'mobis')->name('mobis'); // Route to check if a good has mobis
    });


    // Good Page related routs
    Route::controller(GoodController::class)->group(function () {
        Route::get('/goods', 'index')->name('goods'); // goods route lead us to the goods page
        Route::get('/goods/create', 'create')->name('goods.create'); // Route to show the form for creating a new good in the system
        Route::post('/goods', 'store')->name('goods.store'); // Route to create new good in the system
        Route::put('/goods/{goods}/edit', 'edit')->name('goods.edit'); // Route to show the selected good for update
        Route::put('/goods/{goods}', 'update')->name('goods.update'); // Route to update an existing good
        Route::delete('/goods/{goods}', 'delete')->name('goods.delete'); // Route to delete a specific good
    });

    Route::get('/rates', function () {
        return Inertia::render('Dashboard');
    })->name('rates');
});
