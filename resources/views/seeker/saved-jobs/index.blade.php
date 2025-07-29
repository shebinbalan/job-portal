@extends('layouts.app')
@section('title', 'Saved Jobs')

@section('content')
<h4 class="mb-4">⭐ Your Saved Jobs</h4>

{{-- 🔍 Filter Form --}}
<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Filter by keyword">
    </div>
    <div class="col-md-3">
        <select name="industry" class="form-control">
            <option value="">All Industries</option>
            <option value="IT" {{ request('industry') == 'IT' ? 'selected' : '' }}>IT</option>
            <option value="Finance" {{ request('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
            <option value="Healthcare" {{ request('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
        </select>
    </div>
    <div class="col-md-3">
        <select name="type" class="form-control">
            <option value="">All Types</option>
            <option value="Full-time" {{ request('type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
            <option value="Part-time" {{ request('type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
            <option value="Remote" {{ request('type') == 'Remote' ? 'selected' : '' }}>Remote</option>
        </select>
    </div>
    <div class="col-md-3 d-grid">
        <button class="btn btn-outline-primary">Apply Filters</button>
    </div>
</form>

{{-- ⭐ Saved Jobs List --}}
@forelse($savedJobs as $job)
    <div class="card mb-3 p-3" id="job-{{ $job->id }}">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">{{ $job->title }}</h5>
                <p class="mb-0">{{ $job->company->name ?? 'Unknown' }} | {{ $job->location }}</p>
            </div>
            <button 
                class="btn btn-sm btn-outline-danger remove-saved-btn"
                data-job-id="{{ $job->id }}">
                🗑 Remove
            </button>
        </div>
    </div>
@empty
    <p>You haven't saved any jobs yet.</p>
@endforelse
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.remove-saved-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const jobId = this.dataset.jobId;

            fetch(`/saved-jobs/toggle/${jobId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data.saved) {
                    const jobCard = document.getElementById(`job-${jobId}`);
                    if (jobCard) jobCard.remove();
                }
            })
            .catch(err => {
                console.error(err);
                alert('Something went wrong while removing the job.');
            });
        });
    });
</script>
@endsection
