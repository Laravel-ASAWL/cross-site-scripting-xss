<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return view('comments', compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Consulta vulnerable a Cross-Site Scripting XSS
        // $comment = DB::table('comments')->insert(['comment'=> $request->comment]);

        // Validación de entradas
        $validated = $request->validate([
            'comment' => 'required|string',
        ]);

        // Sanitización de entradas
        $comment = e($validated['comment']);

        // Utilización de Eloquent ORM
        Comment::create([
            'comment' => $comment,
        ]);

        // retorno
        return redirect()->route('home');
    }
}
