<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\NoteController;
use App\Http\Middleware\EnsureHabitOwnership;
use App\Http\Middleware\EnsureNoteOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('habits')->group(function () {
        Route::post('', [HabitController::class, 'addHabit']);
        Route::get('', [HabitController::class, 'getHabits']);

        Route::middleware([EnsureHabitOwnership::class])->group(function () {
            Route::patch('/{id}', [HabitController::class, 'updateHabit']);
            Route::delete('/{id}', [HabitController::class, 'deleteHabit']);
            Route::patch('/{id}/toggle', [HabitController::class, 'toggleHabit']);
        });
    });

    Route::prefix('notes')->group(function () {
        Route::post('', [NoteController::class, 'addNote']);
        Route::get('', [NoteController::class, 'getNotes']);

        Route::middleware([EnsureNoteOwnership::class])->group(function () {
            Route::patch('/{id}', [NoteController::class, 'updateNote']);
            Route::delete('/{id}', [NoteController::class, 'deleteNote']);
        });
    });

});
