<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('投稿作成') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- エラーメッセージの表示 -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-500 text-xs italic">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- 本の検索フォーム -->
                    <form action="{{ route('books.search') }}" method="GET">
                        <div class="mb-4">
                            <label for="search" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">本を検索する</label>
                            <input type="text" name="keyword" id="search" placeholder="本のタイトルや著者名" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">検索</button>
                        </div>
                    </form>

                    <!-- 検索結果があれば表示 -->
                    @if(isset($books) && count($books) > 0)
                        <h3 class="text-lg font-semibold">検索結果</h3>
                        <div>
                            @foreach($books as $book)
                                <div class="my-2">
                                    <strong>{{ $book['volumeInfo']['title'] }}</strong>
                                    @if (isset($book['volumeInfo']['imageLinks']))
                                        <img src="{{ $book['volumeInfo']['imageLinks']['thumbnail'] }}" alt="{{ $book['volumeInfo']['title'] }}のサムネイル">
                                    @endif
                                    <p>著者: {{ implode(', ', $book['volumeInfo']['authors'] ?? ['著者不明']) }}</p>
                                    <p>出版日: {{ $book['volumeInfo']['publishedDate'] ?? '不明' }}</p>
                                    <p>説明: {{ $book['volumeInfo']['description'] ?? '説明がありません。' }}</p>
                                    
                                    <button type="button" class="select-book bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" data-id="{{ $book['id'] }}" data-title="{{ $book['volumeInfo']['title'] }}">この本を選択する</button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>検索結果はありません。</p>
                    @endif

                    <!-- 投稿フォーム -->
                    <form method="POST" action="{{ route('books.store') }}">
                        @csrf

                        <!-- タイトル入力 -->
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">タイトル</label>
                            <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('title')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- 内容入力 -->
                        <div class="mb-4">
                            <label for="content" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">内容</label>
                            <textarea name="content" id="content" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            @error('content')
                                <span class="text-red-500 text-xs italic">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- 選択された本の情報を隠しフィールドで送信 -->
                        <input type="hidden" name="book_id" id="book_id">
                        <input type="hidden" name="book_title" id="book_title">

                        <!-- 送信ボタン -->
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">投稿する</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // 本を選択するボタンの動作
        document.querySelectorAll('.select-book').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('book_id').value = this.dataset.id;
                document.getElementById('book_title').value = this.dataset.title;
            });
        });
    </script>
</x-app-layout>
