<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

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
            'name' => 'required|string|max:255',
            'book_category_id' => 'required|exists:book_categories,id',
            'author' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
        ]);

        // Proses unggah gambar
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Simpan data buku
        Book::create([
            'name' => $request->name,
            'book_category_id' => $request->book_category_id,
            'author' => $request->author,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath, // Simpan path gambar
        ]);

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
            'name' => 'required|string|max:255',
            'book_category_id' => 'required|exists:book_categories,id',
            'description' => 'nullable|string',
            'author' => 'required|string|max:255',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function export($id)
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }

    // Method untuk mengimpor data buku
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        try {
            Excel::import(new BooksImport, $request->file('file'));
            return redirect()->back()->with('success', 'Books imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to import books: ' . $e->getMessage());
        }
    }
    
    public function destroy(Book $book)
    {
        
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
