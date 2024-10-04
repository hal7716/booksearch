<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // コメントがどの投稿 (Book) に関連しているかを示す外部キー
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            // コメントを投稿したユーザーのID
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // コメントの内容
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
