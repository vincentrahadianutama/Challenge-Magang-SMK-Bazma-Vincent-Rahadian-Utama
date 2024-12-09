<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use App\Imports\BooksImport;

class BookImportExportController extends Controller
{
    public function index()
    {
        return view('books.import-export');
    }

    public function export()
    {
        return Excel::download(new BooksExport, 'books.xlsx');
    }

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
}
