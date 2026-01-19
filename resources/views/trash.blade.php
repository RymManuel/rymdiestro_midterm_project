<x-layouts.app :title="__('Trash')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <!-- Back Button & Title -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">📁 Trash - Deleted Books</h1>
            <a href="{{ route('dashboard') }}" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700">
                ← Back to Dashboard
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300"> 
                {{ session('success') }}
            </div>
        @endif

        <!-- Info Alert -->
        <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 dark:border-yellow-900/30 dark:bg-yellow-900/20">
            <p class="text-sm text-yellow-800 dark:text-yellow-300">
                ℹ️ Soft-deleted books are shown here. You can restore them or permanently delete them.
            </p>
        </div>

        <!-- Trash Items -->
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex h-full flex-col p-6">
                <h2 class="mb-4 text-lg font-semibold text-neutral-900 dark:text-neutral-100">Deleted Items ({{ $books->total() }})</h2>
                
                <div class="flex-1 overflow-auto">
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full">
                            <thead>
                                <tr class="border-b border-neutral-200 bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900/50">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">#</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Title</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Author</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">ISBN</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Category</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Deleted On</th>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
                                @forelse($books as $book)
                                    <tr class="transition-colors hover:bg-neutral-50 dark:hover:bg-neutral-800/50 opacity-75">
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                                        <td class="px-4 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">{{ $book->title }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->author }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">{{ $book->isbn }}</td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                            <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ $book->category ? $book->category->name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                            {{ $book->deleted_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            <form action="{{ route('books.restore', $book) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 transition-colors hover:text-green-700 dark:text-green-400 dark:hover:text-green-300" onclick="return confirm('Restore this book?')">
                                                    Restore
                                                </button>
                                            </form>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('books.force-delete', $book) }}" method="POST" class="inline" onsubmit="return confirm('Permanently delete this book? This cannot be undone!', 'Are you absolutely sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete Permanently
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            🎉 Trash is empty! No deleted books.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $books->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
