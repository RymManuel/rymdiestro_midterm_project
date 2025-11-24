<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class BookController extends Controller
{
    /**
     * Display dashboard with books and categories
     */
    public function index()
    {

        $books = Book::with('category')->latest()->get();
        $categories = Category::all();
        $activeCategories = Category::count();
        $booksCreated = Book::whereMonth('created_at', now()->month)->count();

        return view('dashboard', compact('books', 'categories', 'activeCategories','booksCreated'));
    }

    /**
     * Store a new book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'category_id' => 'required|exists:categories,id',
        ]);

        Book::create($validated);
        return redirect()->back()->with('success', 'Book added successfully.');
    }

    /**
     * Update an existing book
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'category_id' => 'required|exists:categories,id',
        ]);

        $book->update($validated);

        return redirect()->back()->with('success', 'Book updated successfully.');
    }

    /**
     * Delete a book
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->back()->with('success', 'Book deleted successfully.');
    }
}