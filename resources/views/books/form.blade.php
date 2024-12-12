@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $book->name ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="book_category_id">Category</label>
            <select class="form-control" id="book_category_id" name="book_category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('book_category_id', $book->book_category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ old('description', $book->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="author" class="form-control" value="{{ old('author', $book->author ?? '') }}" required>
        </div>

        <div class="form-group">
            <label for="thumbnail">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control" {{ isset($book) ? '' : 'required' }}>
            @if(isset($book) && $book->thumbnail)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $book->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" style="width: 150px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection

