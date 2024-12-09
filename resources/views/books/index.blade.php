@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Books</h1>
    <a href="{{ route('books.create') }}" class="btn btn-primary mb-3">Add Book</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button id="exportExcel" class="btn btn-info mb-3">Export to Excel</button>

    <table class="table table-bordered" id="bookTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Author</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->name }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->description }}</td>
                    <td>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script>
    document.getElementById('exportExcel').addEventListener('click', () => {
        const table = document.getElementById('bookTable');
        if (!table) {
            alert('Tabel tidak ditemukan!');
            return;
        }

        const worksheet = XLSX.utils.table_to_sheet(table);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Books');

        XLSX.writeFile(workbook, 'Books.xlsx');
    });
</script>
@endsection
