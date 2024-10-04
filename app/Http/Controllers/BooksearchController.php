<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BooksearchController extends Controller
{
    /**
     * 書籍を検索する
     */
    public function search(Request $request)
    {   
        // 直接APIキーを設定
        $apiKey = 'AIzaSyBisUgPLNXw5noB23X4zcACyzfDptsAxUc'; // ここに直接APIキーを入力

        // 検索キーワードの取得
        $keyword = $request->input('keyword');
        dd('検索キーワード:', $keyword); // ここでキーワードを出力

        // Google Books APIにリクエストを送信（タイトルのみで検索）
        $url = 'https://www.googleapis.com/books/v1/volumes?q=' . urlencode($keyword) . '&country=JP&key=' . $apiKey;
        dd('APIリクエストURL:', $url); // ここでURLを出力

        // APIリクエスト送信前のログ
        \Log::info('APIリクエストを送信中', ['url' => $url]);

        // Google Books APIにリクエストを送信
        $response = Http::get($url);

        // エラーハンドリング
        if ($response->failed()) {
            return redirect()->back()->withErrors(['error' => 'APIリクエストに失敗しました: ' . $response->body()]);
        }

        // レスポンスから書籍情報を取得
        $books = $response->json()['items'] ?? [];

        // 検索結果をビューに渡す
        return view('books.create', compact('books', 'keyword'));
    }
    

    /**
     * 書籍の詳細を表示する
     */
    public function show($id)
    {
        // 直接APIキーを設定
        $apiKey = 'AIzaSyBisUgPLNXw5noB23X4zcACyzfDptsAxUc'; // ここに直接APIキーを入力

        // Google Books APIから書籍の詳細を取得
        $response = Http::get("https://www.googleapis.com/books/v1/volumes/{$id}?key={$apiKey}");

        // 書籍の詳細情報を取得
        $book = $response->json();
        dd($book); // ここで詳細情報を出力

        // 詳細ページのビューに渡す
        return view('books.show', compact('book'));
    }
}
