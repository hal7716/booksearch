<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // DBファサードをインポート

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 投稿と評価データを取得し、平均評価でソート
        $books = book::with(['user', 'ratings'])
            ->withCount(['ratings as average_rating' => function ($query) {
                $query->select(DB::raw('avg(rating)')); // 平均評価を計算
            }])
            ->orderBy('average_rating', 'desc') // 平均評価で降順にソート
            ->latest() // 作成日時でソート（最新順）
            ->get();

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'book_id' => 'nullable|string',
            'book_title' => 'nullable|string',
        ]);

        // 新しい本の投稿を作成
        $book = new Book([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'book_id' => $validated['book_id'], // Google Books APIのID
            'book_title' => $validated['book_title'], // 本のタイトル
        ]);

        // データベースに保存
        $book->save();

        // 投稿一覧画面にリダイレクト
        return redirect()->route('books.index')->with('success', '投稿が作成されました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        // 投稿に紐づくコメントを一緒に取得する
        $book->load('comments');
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // フォームバリデーション
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // タイトルと内容を更新
        $book->title = $validated['title'];
        $book->content = $validated['content'];

        // データベースに保存
        $book->save();

        // 更新後のリダイレクト
        return redirect()->route('books.show', $book)->with('success', '投稿が更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // 投稿の削除処理
        $book->delete();

        // 投稿一覧画面にリダイレクト
        return redirect()->route('books.index')->with('success', '投稿が削除されました。');
    }
}
