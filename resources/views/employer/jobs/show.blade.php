@extends('employer-layout.app')

@section('title', $job->title)
@section('header', 'Job Details')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">{{ $job->title }}</h4>
            <p><strong>Location:</strong> {{ $job->location }}</p>
            <p><strong>Type:</strong> {{ ucfirst($job->type) }}</p>
            <p><strong>Salary:</strong>
                @if($job->salary_min || $job->salary_max)
                    {{ $job->salary_min ? '₹' . $job->salary_min : '' }}
                    -
                    {{ $job->salary_max ? '₹' . $job->salary_max : '' }}
                @else
                    Not disclosed
                @endif
            </p>
            <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($job->deadline)->format('Y-m-d') }}</p>

            <hr>
            <p>{!! nl2br(e($job->description)) !!}</p>

            <a href="{{ route('employer.jobs.edit', $job) }}" class="btn btn-outline-primary mt-3">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        </div>
    </div>
@endsection
