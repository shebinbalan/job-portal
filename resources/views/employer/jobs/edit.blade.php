@extends('employer-layout.app')

@section('title', 'Edit Job')
@section('header', 'Edit Job Post')

@section('content')
    <form method="POST" action="{{ route('employer.jobs.update', $job) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Job Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $job->location) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Job Type</label>
            <select name="type" class="form-select" required>
                @foreach (['full-time', 'part-time', 'internship', 'contract'] as $type)
                    <option value="{{ $type }}" {{ $job->type === $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Categories</label>
            <select name="categories[]" class="form-select" multiple>
                @foreach ($allCategories as $category)
                    <option value="{{ $category->id }}"
                        {{ in_array($category->id, old('categories', $job->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple.</small>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label class="form-label">Salary Min</label>
                <input type="number" name="salary_min" class="form-control" value="{{ $job->salary_min }}">
            </div>
            <div class="col">
                <label class="form-label">Salary Max</label>
                <input type="number" name="salary_max" class="form-control" value="{{ $job->salary_max }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control"
                   value="{{ \Carbon\Carbon::parse($job->deadline)->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="5" class="form-control" required>{{ $job->description }}</textarea>
        </div>

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $job->is_active ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <button class="btn btn-success">
            <i class="bi bi-check2-circle me-1"></i> Update Job
        </button>
    </form>
@endsection
