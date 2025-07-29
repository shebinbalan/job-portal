@extends('admin-layout.app')

@section('title', 'Add Category')
@section('header', 'Add Category')

@section('content')
    <form method="POST" action="{{ route('admin.categories.store') }}" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button class="btn btn-success">Create</button>
    </form>
@endsection
