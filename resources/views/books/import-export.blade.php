@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Books Import & Export</h1>

        <!-- Form untuk Import -->
        <form action="{{ route('books.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Import Books (Excel or CSV)</label>
                <input type="file" class="form-control" name="file" id="file" required>
            </div>
            <button type="submit" class="btn btn-success">Import</button>
        </form>

        <hr>

        <!-- Tombol untuk Export -->
        <a href="{{ route('books.export') }}" class="btn btn-primary">Export Books</a>
    </div>
@endsection
