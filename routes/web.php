<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookImportExportController;


Route::get('/', function () {
    return view('welcome');
});

//CRUD book_categories
Route::resource('book_categories', BookCategoryController::class);

//CRUD Books
Route::resource('books', BookController::class);

Route::get('books/import-export', [BookImportExportController::class, 'index'])->name('books.import-export');
Route::post('books/import', [BookImportExportController::class, 'import'])->name('books.import');
Route::get('books/export', [BookImportExportController::class, 'export'])->name('books.export');
