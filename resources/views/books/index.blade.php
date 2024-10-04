<!-- resources/views/books/index.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('投稿一覧') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          @foreach ($books as $book)
          <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
            <!-- 本のタイトルと内容を表示 -->
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $book->title }}</h3>
            <p class="text-gray-800 dark:text-gray-300">{{ $book->content }}</p>

            <!-- 投稿者情報 -->
            <p class="text-gray-600 dark:text-gray-400 text-sm">投稿者: {{ $book->user->name }}</p>

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

            <!-- 評価ボタン -->
            <div class="flex items-center mt-2">
              <form action="{{ route('books.rate', $book) }}" method="POST">
                @csrf
                <select name="rating" class="mr-2 bg-black text-white rounded">
                  <option value="1">★☆☆☆☆</option>
                  <option value="2">★★☆☆☆</option>
                  <option value="3">★★★☆☆</option>
                  <option value="4">★★★★☆</option>
                  <option value="5">★★★★★</option>
                </select>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded">
                  評価する
                </button>
              </form>
            </div>
            
            <!-- 詳細リンク -->
            <a href="{{ route('books.show', $book) }}" class="text-blue-500 hover:text-blue-700">詳細を見る</a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</x-app-layout>
