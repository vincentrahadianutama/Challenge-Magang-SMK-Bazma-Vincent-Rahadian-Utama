<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->get();
        return view('books.index', compact('books'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('books.import-export', compact('book'));
    }

    public function create()
    {
        $categories = BookCategory::all();
        return view('books.create', compact('categories'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'book_category_id' => 'required|exists:book_categories,id',
            'description' => 'required|string',
            'author' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $book = new Book($request->except('thumbnail'));

        // Upload gambar thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            $book->thumbnail = $request->file('thumbnail')->store('book_thumbnails', 'public');
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }



    public function edit(Book $book)
    {
        $categories = BookCategory::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'name' => 'required|string',
            'book_category_id' => 'required|exists:book_categories,id',
            'description' => 'required|string',
            'author' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $book->fill($request->except('thumbnail'));

        // Periksa dan upload gambar baru jika ada
        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama jika ada
            if ($book->thumbnail) {
                Storage::disk('public')->delete($book->thumbnail);
            }

            $book->thumbnail = $request->file('thumbnail')->store('book_thumbnails', 'public');
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    // Method untuk mengimpor data buku
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new BooksImport, $request->file('file'));
            return redirect()->route('books.index')->with('success', 'Books imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', 'Failed to import books: ' . $e->getMessage());
        }
    }


    
    public function destroy(Book $book)
    {
        // Hapus gambar jika ada
        if ($book->thumbnail) {
            Storage::disk('public')->delete($book->thumbnail);
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }

}
