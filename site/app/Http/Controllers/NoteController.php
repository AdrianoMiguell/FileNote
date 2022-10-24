<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function dashboard()
    {
        $notes = Note::where('user-id','=',Auth::user()->id)
            ->get();
        return view('dashboard', compact($notes));
    }
}
