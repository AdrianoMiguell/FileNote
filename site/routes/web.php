<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rota do delete
Route::delete('/users/{id}', [NoteController::class, 'delete'])->name('users.delete');
// Rota para o dashboard
Route::get('/dashboard', [NoteController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
// Rota para criação de notas
Route::post('create_note', [NoteController::class, 'create'])->name('create.note');
// Rota para editar anotação
Route::post('editar_anotacao', [NoteController::class, 'update'])->name('update.note');


require __DIR__.'/auth.php';
