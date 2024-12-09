<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookCategoryController extends Controller
{
    public function index()
    {
        $categories = BookCategory::all();
        return view('book_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('book_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:book_categories,name',
        ]);

        BookCategory::create($request->all());
        return redirect()->route('book_categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(BookCategory $bookCategory)
    {
        return view('book_categories.edit', compact('bookCategory'));
    }

    public function update(Request $request, BookCategory $bookCategory)
    {
        $request->validate([
            'name' => 'required|unique:book_categories,name,' . $bookCategory->id,
        ]);

        $bookCategory->update($request->all());
        return redirect()->route('book_categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy(BookCategory $bookCategory)
    {
        $bookCategory->delete();
        return redirect()->route('book_categories.index')->with('success', 'Category deleted successfully!');
    }
}
