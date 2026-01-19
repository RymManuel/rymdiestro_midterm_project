<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display dashboard with books and categories (with search/filter support)
     */
    public function index(Request $request)
    {
        // Start query with active (non-soft-deleted) books
        $query = Book::with('category');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category_id', $category);
        }

        // Get filtered results and pagination
        $books = $query->latest()->paginate(15);
        $books->appends($request->query()); // Preserve query parameters on pagination

        // Get all categories for filter dropdown
        $categories = Category::all();
        $activeCategories = Category::count();
        $booksCreated = Book::whereMonth('created_at', now()->month)->count();

        return view('dashboard', compact('books', 'categories', 'activeCategories', 'booksCreated'));
    }

    /**
     * Store a new book with optional photo upload
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpg,png|max:2048', // 2MB max
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('items', $filename, 'public');
            $validated['photo'] = $filename;
        }

        Book::create($validated);
        return redirect()->back()->with('success', 'Book added successfully.');
    }

    /**
     * Update an existing book with optional photo upload
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpg,png|max:2048', // 2MB max
        ]);

        // Handle photo upload (delete old if exists)
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($book->photo) {
                Storage::disk('public')->delete('items/' . $book->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('items', $filename, 'public');
            $validated['photo'] = $filename;
        }

        $book->update($validated);

        return redirect()->back()->with('success', 'Book updated successfully.');
    }

    /**
     * Soft delete a book
     */
    public function destroy(Book $book)
    {
        $book->delete(); // Soft delete
        return redirect()->back()->with('success', 'Book moved to trash.');
    }

    /**
     * Display trash (soft-deleted books)
     */
    public function trash(Request $request)
    {
        // Get only soft-deleted books
        $books = Book::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(15);

        $categories = Category::all();

        return view('trash', compact('books', 'categories'));
    }

    /**
     * Restore a book from trash
     */
    public function restore(Book $book)
    {
        $book->restore();
        return redirect()->back()->with('success', 'Book restored successfully.');
    }

    /**
     * Permanently delete a book
     */
    public function forceDelete(Book $book)
    {
        // Delete associated photo first
        if ($book->photo) {
            Storage::disk('public')->delete('items/' . $book->photo);
        }

        $book->forceDelete();
        return redirect()->back()->with('success', 'Book permanently deleted.');
    }

    /**
     * Export filtered books to PDF
     */
    public function exportPdf(Request $request)
    {
        // Build query with same filters as index
        $query = Book::with('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category_id', $category);
        }

        $books = $query->latest()->get();
        $filename = 'Books_Export_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return \PDF::loadView('books.pdf', compact('books'))
            ->download($filename);
    }
}