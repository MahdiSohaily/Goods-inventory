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

    // Dashboard route lead us to the search page
    Route::get('/dashboard', [SearchController::class, 'index'])->name('dashboard');
    // Route to manage searched path
    Route::post('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/mobis/{id}', [SearchController::class, 'mobis'])->name('mobis');






    Route::get('/goods', function () {
        return Inertia::render('Dashboard');
    })->name('goods');

    Route::get('/rates', function () {
        return Inertia::render('Dashboard');
    })->name('rates');
});
