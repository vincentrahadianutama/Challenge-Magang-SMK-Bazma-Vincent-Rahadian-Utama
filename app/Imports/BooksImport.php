<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow
{
    /**
     * Mengimpor data buku dari Excel ke database
     *
     * @param array $row
     * @return \App\Models\Book
     */
    public function model(array $row)
    {
        return new Book([
            'name' => $row['name'],
            'book_category_id' => $row['book_category_id'],
            'description' => $row['description'],
            'author' => $row['author'],
        ]);
    }
}
