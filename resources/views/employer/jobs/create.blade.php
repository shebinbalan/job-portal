@extends('employer-layout.app')

@section('title', 'Post New Job')
@section('header', 'Create Job Post')

@section('content')
    <form method="POST" action="{{ route('employer.jobs.store') }}" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Job Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Job Type</label>
            <select name="type" class="form-select" required>
                <option value="">-- Select --</option>
                @foreach (['full-time', 'part-time', 'internship', 'contract'] as $type)
                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="categories" class="form-label">Categories</label>
            <select name="categories[]" class="form-select" multiple>
                @foreach ($allCategories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple.</small>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label for="salary_min" class="form-label">Salary Min</label>
                <input type="number" name="salary_min" class="form-control" value="{{ old('salary_min') }}">
            </div>
            <div class="col">
                <label for="salary_max" class="form-label">Salary Max</label>
                <input type="number" name="salary_max" class="form-control" value="{{ old('salary_max') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Application Deadline</label>
            <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Job Description</label>
            <textarea name="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
        </div>

        <button class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Post Job
        </button>
    </form>
@endsection
