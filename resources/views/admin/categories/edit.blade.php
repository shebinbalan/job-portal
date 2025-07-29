@extends('admin-layout.app')

@section('title', 'Edit Category')
@section('header', 'Edit Category')

@section('content')
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="card p-4 shadow-sm">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
@endsection
