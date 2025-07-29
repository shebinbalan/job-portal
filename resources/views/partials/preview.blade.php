{{-- resources/views/seeker/partials/preview.blade.php --}}

<h4>{{ $job->title }}</h4>

<p><strong>Company:</strong> {{ $job->company->name ?? 'N/A' }}</p>
<p><strong>Location:</strong> {{ $job->location }}</p>
<p><strong>Type:</strong> <span class="badge bg-info">{{ ucfirst($job->job_type ?? $job->type) }}</span></p>
<p><strong>Category:</strong> {{ $job->category->name ?? 'Uncategorized' }}</p>

<hr>

<div>{!! nl2br(e($job->description)) !!}</div>

@if ($job->requirements)
    <hr>
    <h6>Requirements:</h6>
    <div>{!! nl2br(e($job->requirements)) !!}</div>
@endif
