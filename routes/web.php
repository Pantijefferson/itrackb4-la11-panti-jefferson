<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComicController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/whoami', function () {
    return 'jefferson T. Panti | 2023-70946 | Block 4C | ITRACKB4 Laravel 12';
});


Route::get('/comics/feature', [ComicController::class, 'feature'])
    ->name('comics.feature');


Route::get('/comics/filter/{value?}', function ($value = null) {
    if ($value === null) {
        return redirect()->route('comics.index');
    }

    return redirect()->route('comics.index', [
        'genre' => $value,
    ]);
})->name('comics.filter');


Route::resource('comics', ComicController::class);