<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {

        $categories = Category::latest()->get();
        return view('category', compact('categories'));
    }

    /**
     * Store a new department in database
     * Validates input then creates department
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create($validated);
        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);
    

        $category->update($validated);
        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    /**
     * Delete a department from database
     * Removes department by ID
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
