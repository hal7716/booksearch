<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // 設定できるカラムを追加
    protected $fillable = ['comment', 'book_id', 'user_id'];

    // 投稿 (Book) との多対1の関係
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // ユーザーとの多対1の関係
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
