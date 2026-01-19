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
            <!-- Total Books Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 p-6 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:from-blue-600 dark:to-blue-800">
                <div class="absolute right-0 top-0 -mr-8 -mt-8 h-32 w-32 rounded-full bg-white/10 transition-transform duration-300 group-hover:scale-150"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-blue-100">Total Books</p>
                            <h3 class="mt-2 text-4xl font-bold text-white">{{ $books->total() }}</h3>
                        </div>
                        <svg class="h-12 w-12 text-blue-200 opacity-80 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Categories Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-6 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:from-emerald-600 dark:to-emerald-800">
                <div class="absolute right-0 top-0 -mr-8 -mt-8 h-32 w-32 rounded-full bg-white/10 transition-transform duration-300 group-hover:scale-150"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-emerald-100">Active Categories</p>
                            <h3 class="mt-2 text-4xl font-bold text-white">{{ $activeCategories }}</h3>
                        </div>
                        <svg class="h-12 w-12 text-emerald-200 opacity-80 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Books This Month Card -->
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-violet-500 to-violet-700 p-6 shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl dark:from-violet-600 dark:to-violet-800">
                <div class="absolute right-0 top-0 -mr-8 -mt-8 h-32 w-32 rounded-full bg-white/10 transition-transform duration-300 group-hover:scale-150"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-violet-100">Added This Month</p>
                            <h3 class="mt-2 text-4xl font-bold text-white">{{ $booksCreated }}</h3>
                        </div>
                        <svg class="h-12 w-12 text-violet-200 opacity-80 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

        <!-- Main Content -->
        <div class="rounded-2xl border border-neutral-200 bg-white p-8 shadow-lg dark:border-neutral-700 dark:bg-neutral-800">
            <!-- Add Book Section -->
            <div class="mb-8">
                <div class="mb-6 flex items-center gap-3">
                    <div class="rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 p-2">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">Add New Book</h2>
                </div>
                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-4">
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Title</label>
                            <input type="text" name="title" required class="mt-2 w-full rounded-lg border-2 border-neutral-200 bg-white px-4 py-2.5 text-neutral-900 placeholder-neutral-400 transition-all focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:placeholder-neutral-500" placeholder="Enter book title">
                            @error('title')
                                <span class="mt-1 block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Author</label>
                            <input type="text" name="author" required class="mt-2 w-full rounded-lg border-2 border-neutral-200 bg-white px-4 py-2.5 text-neutral-900 placeholder-neutral-400 transition-all focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:placeholder-neutral-500" placeholder="Enter author name">
                            @error('author')
                                <span class="mt-1 block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">ISBN</label>
                            <input type="text" name="isbn" required class="mt-2 w-full rounded-lg border-2 border-neutral-200 bg-white px-4 py-2.5 text-neutral-900 placeholder-neutral-400 transition-all focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:placeholder-neutral-500" placeholder="Enter ISBN">
                            @error('isbn')
                                <span class="mt-1 block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Category</label>
                            <select name="category_id" class="mt-2 w-full rounded-lg border-2 border-neutral-200 bg-white px-4 py-2.5 text-neutral-900 transition-all focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="mt-1 block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300">Photo (JPG, PNG only - Max 2MB)</label>
                            <input type="file" name="photo" accept="image/jpeg,image/png" class="mt-2 w-full rounded-lg border-2 border-neutral-200 bg-white px-4 py-2.5 text-neutral-900 file:mr-2 file:rounded file:border-0 file:bg-blue-600 file:px-3 file:py-1 file:text-sm file:font-medium file:text-white transition-all focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:file:bg-blue-700">
                            @error('photo')
                                <span class="mt-1 block text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="transform rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-2.5 font-semibold text-white shadow-lg transition-all hover:scale-105 hover:shadow-xl active:scale-95 dark:from-blue-700 dark:to-blue-800">
                            + Add Book
                        </button>
                    </div>
                </form>
            </div>

            <div class="my-8 border-t border-neutral-200 dark:border-neutral-700"></div>

            <!-- Search and Filter Section -->
            <div class="mb-8 space-y-4">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="rounded-lg bg-gradient-to-br from-emerald-500 to-emerald-600 p-2">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-neutral-900 dark:text-neutral-100">Books Library</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('books.trash') }}" class="flex items-center gap-2 transform rounded-lg border-2 border-orange-500 bg-white px-4 py-2 text-sm font-semibold text-orange-600 shadow-md transition-all hover:scale-105 hover:shadow-lg dark:bg-neutral-700 dark:text-orange-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Trash <span class="ml-1 inline-block rounded-full bg-orange-100 px-2 py-0.5 text-xs font-bold text-orange-600 dark:bg-orange-900/30 dark:text-orange-300">{{ \App\Models\Book::onlyTrashed()->count() }}</span>
                        </a>
                        <a href="{{ route('books.export-pdf', ['search' => request('search'), 'category' => request('category')]) }}" class="flex items-center gap-2 transform rounded-lg bg-gradient-to-r from-emerald-500 to-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-lg transition-all hover:scale-105 hover:shadow-xl dark:from-emerald-600 dark:to-emerald-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export PDF
                        </a>
                    </div>
                </div>

                <form method="GET" action="{{ route('dashboard') }}" class="space-y-3">
                    <div class="grid gap-3 md:grid-cols-3">
                        <div>
                            <input type="text" name="search" placeholder="Search by title or author..." value="{{ request('search') }}" class="w-full rounded-lg border-2 border-neutral-200 bg-white px-4 py-2.5 text-neutral-900 placeholder-neutral-400 transition-all focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:placeholder-neutral-500">
                        </div>
                        <div>
                            <select name="category" class="w-full rounded-lg border-2 border-neutral-200 bg-white px-4 py-2.5 text-neutral-900 transition-all focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="transform rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-2.5 font-semibold text-white shadow-md transition-all hover:scale-105 hover:shadow-lg active:scale-95 dark:from-blue-700 dark:to-blue-800">🔍 Search</button>
                            <a href="{{ route('dashboard') }}" class="transform rounded-lg border-2 border-neutral-300 bg-white px-4 py-2.5 text-center font-semibold text-neutral-700 shadow-sm transition-all hover:scale-105 hover:shadow-md dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700">✕ Clear</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Books Table -->
            <div class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b-2 border-neutral-200 bg-gradient-to-r from-neutral-50 to-neutral-100 dark:border-neutral-700 dark:from-neutral-900 dark:to-neutral-800">
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300">#</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300">Photo</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300">Author</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300">ISBN</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        @forelse($books as $book)
                            <tr class="transition-all duration-200 hover:bg-blue-50 dark:hover:bg-neutral-700/30">
                                <td class="px-6 py-4 text-sm font-medium text-neutral-600 dark:text-neutral-400">{{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($book->photo)
                                        <img src="{{ $book->getPhotoPath() }}" alt="{{ $book->title }}" class="h-10 w-10 rounded-lg object-cover shadow-md">
                                    @else
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-xs font-bold text-white shadow-md">
                                            {{ $book->getInitials() }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-neutral-900 dark:text-neutral-100">{{ $book->title }}</td>
                                <td class="px-6 py-4 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->author }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-neutral-600 dark:text-neutral-400">{{ $book->isbn }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center rounded-full bg-gradient-to-r from-blue-100 to-blue-200 px-3 py-1 text-xs font-bold text-blue-700 dark:from-blue-900/30 dark:to-blue-800/30 dark:text-blue-300">
                                        {{ $book->category ? $book->category->name : 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <button onclick="editBook({{ $book->id }}, '{{ addslashes($book->title) }}', '{{ addslashes($book->author) }}', '{{ $book->isbn }}', {{ $book->category_id }})"
                                            class="transform rounded-md bg-blue-500 px-3 py-1.5 font-semibold text-white transition-all hover:scale-110 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
                                        ✏️ Edit
                                    </button>
                                    <span class="mx-2 text-neutral-300">|</span>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Move this book to trash?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="transform rounded-md bg-red-500 px-3 py-1.5 font-semibold text-white transition-all hover:scale-110 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700">🗑️ Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="h-16 w-16 text-neutral-300 dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <p class="text-lg font-semibold text-neutral-500 dark:text-neutral-400">No books found</p>
                                        <p class="text-sm text-neutral-400 dark:text-neutral-500">Add your first book using the form above</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $books->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

    <!-- Edit Book Modal -->
    <div id="editBookModal" class="fixed inset-0 hidden flex items-center justify-center bg-black/50 z-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 dark:bg-neutral-800">
            <h2 class="mb-4 text-lg font-bold text-neutral-900 dark:text-neutral-100">Edit Book</h2>
            <form id="editBookForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Title</label>
                    <input type="text" id="edit_title" name="title" required class="mt-1 w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-neutral-900 placeholder-neutral-500 transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:placeholder-neutral-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Author</label>
                    <input type="text" id="edit_author" name="author" required class="mt-1 w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-neutral-900 placeholder-neutral-500 transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:placeholder-neutral-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">ISBN</label>
                    <input type="text" id="edit_isbn" name="isbn" required class="mt-1 w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-neutral-900 placeholder-neutral-500 transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:placeholder-neutral-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                    <select id="edit_category_id" name="category_id" class="mt-1 w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-neutral-900 transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Photo (JPG, PNG only - Max 2MB)</label>
                    <input type="file" name="photo" accept="image/jpeg,image/png" class="mt-1 w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-neutral-900 file:mr-2 file:rounded file:border-0 file:bg-blue-600 file:px-3 file:py-1 file:text-sm file:font-medium file:text-white transition-colors focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-neutral-600 dark:bg-neutral-900 dark:text-neutral-100 dark:file:bg-blue-700">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditBookModal()" class="rounded-lg border border-neutral-300 bg-white px-4 py-2 font-medium text-neutral-700 transition-colors hover:bg-neutral-50 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors hover:bg-blue-700 dark:hover:bg-blue-800">
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
