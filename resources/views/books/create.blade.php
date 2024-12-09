@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Book</h1>
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        @include('books.form')
    </form>
</div>
@endsection
