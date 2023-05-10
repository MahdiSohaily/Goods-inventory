<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
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

    Route::get('/goods', function () {
        return Inertia::render('Dashboard');
    })->name('goods');

    Route::get('/rates', function () {
        return Inertia::render('Dashboard');
    })->name('rates');
});
