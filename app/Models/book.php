<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // 投稿 (Book) に紐づくコメントとの1対多の関係
    public function comments()
    {
        //return $this->hasMany(Comment::class);
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    // 評価とのリレーション
    public function ratings()
    {
        return $this->belongsToMany(User::class, 'ratings')->withPivot('rating')->withTimestamps();
    }
}
