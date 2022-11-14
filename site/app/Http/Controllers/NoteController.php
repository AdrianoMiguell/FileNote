<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;

class NoteController extends Controller
{
    public function dashboard()
    {
        $notes = Note::where('user_id','=',Auth::user()->id)
            ->get();
        return view('dashboard', compact('notes'));
    }

    public function create(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'color' => 'required',
            'image' => 'nullable'
        ],[
            'content.required' => 'O campo :attibute é obrigatório!'
        ]);

    $note = $request->except('_token');
    $note['user_id'] = Auth::user()->id;
    Note::create($note);

    return back();
    }

    public function update(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'color' => 'required',
            'image' => 'nullable'
        ],[
            'content.required' => 'O campo :attibute é obrigatório!'
        ]);

    $note = $request->except('_token');

    Note::find($request->id)->update($note);

    return back();
    }

    // Controller para deletar anotação
    public function delete($id)
    {
        $note = note::find($id);
        $note->delete();

        return back();
    }
}
