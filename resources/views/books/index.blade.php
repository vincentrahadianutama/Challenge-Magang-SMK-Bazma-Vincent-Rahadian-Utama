@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Manage Books</h1>
        <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2">Add Book</i>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Form untuk impor file -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('books.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Import Books</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-upload me-2"></i>Import
                </button>
                <button id="exportExcel" class="btn btn-info">
                    <i class="fas fa-file-export me-2"></i>Export to Excel
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel Buku -->
    <div class="table-responsive">
    <table class="table table-bordered" id="bookTable">
    <thead>
        <tr>
            <th>Thumbnail</th>
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
                <td>
                    @if($book->thumbnail)
                        <img src="{{ asset('storage/' . $book->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" style="width: 50px; height: 50px;">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script>
    document.getElementById('exportExcel').addEventListener('click', () => {
        const table = document.getElementById('bookTable');
        if (!table) {
            alert('Table not found!');
            return;
        }

        const worksheet = XLSX.utils.table_to_sheet(table);
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'Books');

        XLSX.writeFile(workbook, 'Books.xlsx');
    });

    $(document).ready(function() {
        $('#bookTable').DataTable();
    });
</script>
@endsection
