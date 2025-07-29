@extends('layouts.app')
@section('title', $job->title)

@section('content')
    <div class="card p-4 shadow-sm">
        <h3>{{ $job->title }}</h3>
        <p class="text-muted">{{ $job->location }} | Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</p>
        
        <p><strong>Type:</strong> {{ ucfirst($job->type) }}</p>
        <p><strong>Salary:</strong> {{ $job->salary_min ?? 'N/A' }} - {{ $job->salary_max ?? 'N/A' }}</p>
        <p><strong>Company:</strong> {{ $job->company->name ?? 'Unknown' }}</p>
        
        <div class="mt-3">
            <strong>Categories:</strong>
            @foreach ($job->categories as $category)
                <span class="badge bg-primary">{{ $category->name }}</span>
            @endforeach
        </div>

        <hr>

        <p class="mt-3">{{ $job->description }}</p>
    </div>
    <a href="{{ route('seeker.applications.create', $job) }}" class="btn btn-primary mt-3">
    <i class="bi bi-file-earmark-plus"></i> Apply Now
</a>
@endsection
