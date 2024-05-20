<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Book\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum', 'ability' => TokenAbility::BOOK_CRUDS->value], function () {
    Route::controller(BookController::class)
            ->prefix('books')
            ->group(function () {
                Route::get('/paginate', 'index');
                Route::get('/{id}', 'getById');
                Route::post('/', 'store');
                Route::put('/{id}', 'update');
                Route::delete('/{id}', 'destroy');
            });
});