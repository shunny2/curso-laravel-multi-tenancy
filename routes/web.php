<?php

use App\Http\Controllers\Tenant\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'index']);

Route::get('/404-tenant', function () {
    return view('errors.404-tenant');
})->name('404.tenant');

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function() {
    return 'Erro a localizar a rota!';
});
