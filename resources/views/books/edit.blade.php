<!-- resources/views/books/edit.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('投稿編集') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          <a href="{{ route('books.show', $book) }}" class="text-blue-500 hover:text-blue-700 mr-2">詳細に戻る</a>
          
          <form method="POST" action="{{ route('books.update', $book) }}">
            @csrf
            @method('PUT')

            <!-- タイトル入力フィールド -->
            <div class="mb-4">
              <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">タイトル</label>
              <input type="text" name="title" id="title" value="{{ $book->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
              @error('title')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <!-- 内容入力フィールド -->
            <div class="mb-4">
              <label for="content" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">内容</label>
              <textarea name="content" id="content" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $book->content }}</textarea>
              @error('content')
                <span class="text-red-500 text-xs italic">{{ $message }}</span>
              @enderror
            </div>

            <!-- 更新ボタン -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">更新する</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
