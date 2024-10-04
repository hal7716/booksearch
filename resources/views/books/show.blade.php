<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('投稿詳細') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{ route('books.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">一覧に戻る</a>

                    <!-- 投稿のタイトル -->
                    <h3 class="text-gray-800 dark:text-gray-300 text-lg font-bold mb-2">
                        {{ $book['volumeInfo']['title'] ?? 'タイトルが不明です。' }}
                    </h3>

                    <!-- 書籍の詳細情報を表示 -->
                    @if(isset($book['volumeInfo']))
                        <p class="text-gray-800 dark:text-gray-300 text-lg mb-4">著者: {{ implode(', ', $book['volumeInfo']['authors'] ?? ['著者不明']) }}</p>
                        <p class="text-gray-800 dark:text-gray-300">出版日: {{ $book['volumeInfo']['publishedDate'] ?? '不明' }}</p>
                        <p class="text-gray-800 dark:text-gray-300">説明: {{ $book['volumeInfo']['description'] ?? '説明がありません。' }}</p>
                    @else
                        <p>書籍情報が見つかりません。</p>
                    @endif

                    <!-- 投稿の内容 -->
                    <p class="text-gray-800 dark:text-gray-300 text-lg mb-4">{{ $book->content ?? 'コンテンツがありません。' }}</p>

                    <!-- 投稿者の情報 -->
                    <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $book->user->name ?? '不明' }}</p>

                    <!-- 作成・更新日時 -->
                    <div class="text-gray-600 dark:text-gray-400 text-sm">
                        <p>作成日時: {{ $book->created_at->format('Y-m-d H:i') }}</p>
                        <p>更新日時: {{ $book->updated_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <!-- 編集・削除ボタン（投稿者のみ表示） -->
                    @if (auth()->id() == $book->user_id)
                    <div class="flex mt-4">
                        <a href="{{ route('books.edit', $book) }}" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">削除</button>
                        </form>
                    </div>
                    @endif
                    
                    <!-- 現在の平均評価の表示 -->
                    <div class="mt-2">
                        <p>現在の評価: 
                            @if ($book->ratings->count() > 0)
                                {{ number_format($book->ratings->avg('pivot.rating'), 1) }} / 5
                            @else
                                評価がありません
                            @endif
                        </p>
                    </div>
                    
                    <!-- 評価（like/dislike機能） -->
                    <div class="flex mt-4">
                        @if ($book->ratings->contains('user_id', auth()->id()))
                        <form action="{{ route('books.unrate', $book) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">dislike {{ $book->ratings->count() }}</button>
                        </form>
                        @else
                        <form action="{{ route('books.rate', $book) }}" method="POST">
                            @csrf
                            <select name="rating" class="mr-2 bg-black text-white rounded">
                                <option value="1">★☆☆☆☆</option>
                                <option value="2">★★☆☆☆</option>
                                <option value="3">★★★☆☆</option>
                                <option value="4">★★★★☆</option>
                                <option value="5">★★★★★</option>
                            </select>
                            <button type="submit" class="text-blue-500 hover:text-blue-700">like {{ $book->ratings->count() }}</button>
                        </form>
                        @endif
                    </div>

                    <!-- コメント表示 -->
                    <div class="mt-4">
                        <p class="text-gray-600 dark:text-gray-400 ml-4">コメント {{ $book->comments->count() }}</p>
                        <a href="{{ route('books.comments.create', $book) }}" class="text-blue-500 hover:text-blue-700 mr-2">コメントする</a>
                    </div>

                    <!-- コメント一覧表示 -->
                    <div class="mt-4">
                        @foreach ($book->comments as $comment)
                            <p>{{ $comment->comment }} 
                                <span class="text-gray-600 dark:text-gray-400 text-sm">
                                    {{ $comment->user->name }} {{ $comment->created_at->format('Y-m-d H:i') }}
                                </span>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> 
</x-app-layout>
