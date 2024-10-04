<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\BooksearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('books', BookController::class);

    // 🔽 2行追加（評価の追加・削除）
    Route::post('/books/{book}/rate', [RatingController::class, 'store'])->name('books.rate');
    Route::delete('/books/{book}/rate', [RatingController::class, 'destroy'])->name('books.unrate');

    // コメントのリソースルートをネストして定義
    Route::resource('books.comments', CommentController::class);

    // 🔽 書籍検索のルートを追加
    Route::get('/books/search', [BooksearchController::class, 'search'])->name('books.search');
    Route::get('/books/{id}', [BooksearchController::class, 'show'])->name('books.show');
});

require __DIR__.'/auth.php';
