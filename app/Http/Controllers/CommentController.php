<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        // コメント作成ビューに親のBookモデルを渡す
        return view('books.comments.create', compact('book'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Book $book )
    {
        // バリデーション
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        // コメントを作成
        $book->comments()->create([
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);

        // 投稿の詳細ページにリダイレクト
        return redirect()->route('books.show', $book)->with('success', 'コメントを追加しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book,Comment $comment)
    {
        // コメントが正しいBookに属しているか確認
        if ($comment->book_id !== $book->id) {
            abort(404);
        }

        return view('books.comments.show', compact('book', 'comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
