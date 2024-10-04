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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            // 外部キー制約を持つカラム
            $table->foreignId('book_id')->constrained()->cascadeOnDelete(); // 投稿のID
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // ユーザーのID

            // ユニーク制約: 1人のユーザーは1つの投稿に対して1つの評価のみ
            $table->unique(['book_id', 'user_id']);

            // 評価を保存するカラム（1〜5の整数）
            $table->integer('rating')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
