<?php

namespace App\Http\Controllers;
use App\Models\book;
use Illuminate\Http\Request;

class RatingController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        // バリデーション: 1〜5の評価
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // 評価を保存、同じユーザーが同じ投稿に再度評価を付ける場合は更新
        $book->ratings()->syncWithoutDetaching([
            auth()->id() => ['rating' => $request->input('rating')],
        ]);

        // 元のページに戻る
        return back()->with('success', '評価を付けました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // 現在ログインしているユーザーの評価を削除
        $book->ratings()->detach(auth()->id());

        // 元のページに戻る
        return back()->with('success', '評価を削除しました。');
    }
}
