<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [NoteController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::post('create_note', [NoteController::class, 'create'])->name('create.note');
Route::post('editar_anotacao', [NoteController::class, 'update'])->name('update.note');


require __DIR__.'/auth.php';
