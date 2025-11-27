<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <!-- Success Message -->
        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300"> 
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Total Books</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $books->count() }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900/30">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Active Categories</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $activeCategories }}</h3>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-900/30">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400">Books Added This Month</p>
                        <h3 class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $booksCreated }}</h3>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3 dark:bg-purple-900/30">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Book Management Section -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">
                <!-- Add New Book Form -->
                <div class="mb-6 rounded-lg border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Add New Book</h2>

                    <form action="{{ route('books.store') }}" method="POST" class="grid gap-4 md:grid-cols-2">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter book title" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('title')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                            <input type="text" name="author" value="{{ old('author') }}" placeholder="Enter author name" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('author')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">ISBN</label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="Enter ISBN" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            @error('isbn')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-1">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                            <select name="category_id" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->description }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Add Book
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Book List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Book List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Author</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">ISBN</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Category</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($books as $book)
                                    <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50">
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-900 dark:text-neutral-100">{{ $book->title }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->author }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->isbn }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                            {{ $book->category ? $book->category->name : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <button onclick="editBook({{ $book->id }}, '{{ $book->title }}', '{{ $book->author }}', '{{ $book->isbn }}', {{ $book->category_id }})"
                                                    class="text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No books found. Add your first book above!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Book Modal -->
    <div id="editBookModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-2xl rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Book</h2>

            <form id="editBookForm" method="POST">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                        <input type="text" id="edit_title" name="title" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                        <input type="text" id="edit_author" name="author" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">ISBN</label>
                        <input type="text" id="edit_isbn" name="isbn" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                        <select id="edit_category_id" name="category_id" required class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-100">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditBookModal()" class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-100 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                        Update Book
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editBook(id, title, author, isbn, category_id) {
            document.getElementById('editBookModal').classList.remove('hidden');
            document.getElementById('editBookModal').classList.add('flex');
            document.getElementById('editBookForm').action = `/books/${id}`;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_author').value = author;
            document.getElementById('edit_isbn').value = isbn;
            document.getElementById('edit_category_id').value = category_id || '';
        }

        function closeEditBookModal() {
            document.getElementById('editBookModal').classList.add('hidden');
            document.getElementById('editBookModal').classList.remove('flex');
        }
    </script>
</x-layouts.app>
