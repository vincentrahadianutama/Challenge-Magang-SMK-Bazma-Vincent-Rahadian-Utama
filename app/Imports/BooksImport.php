<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\BookCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    /**
     * Model data dari file Excel ke tabel database.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari kategori berdasarkan nama (pastikan nama kategori di Excel sudah sesuai)
        $category = BookCategory::where('name', $row['category'])->first();

        return new Book([
            'name' => $row['name'],
            'book_category_id' => $category ? $category->id : null,
            'author' => $row['author'],
            'description' => $row['description']
        ]);
    }
}
