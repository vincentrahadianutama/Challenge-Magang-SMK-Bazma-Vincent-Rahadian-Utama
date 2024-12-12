@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Manage Books</h1>
        <a href="{{ route('book_categories.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus me-2">Add Category</i>
        </a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('book_categories.edit', $category->id) }}" class="btn btn-warning"><i class="fas fa-edit">EDIT</i></a>
                        <form action="{{ route('book_categories.destroy', $category->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash">DELETE</i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
        $('#table').DataTable();
    });
    </script>
</div>
@endsection
