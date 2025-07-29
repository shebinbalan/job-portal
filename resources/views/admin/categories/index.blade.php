@extends('admin-layout.app')

@section('title', 'Categories')
@section('header', 'Category Management')

@section('content')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">+ Add Category</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th><th>Name</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">No categories found.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
