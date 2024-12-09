<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings
{
    /**
     * Mengambil data buku untuk diexport
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Book::select('id', 'name', 'book_category_id', 'description', 'author', 'created_at', 'updated_at')->get();
    }

    /**
     * Menambahkan heading di file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Category ID',
            'Description',
            'Author',
            'Created At',
            'Updated At',
        ];
    }
}
