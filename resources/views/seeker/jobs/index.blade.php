@extends('layouts.app')
@section('title', 'Browse Jobs')

@section('content')
    <h4 class="mb-4">Available Jobs</h4>
<form method="GET" action="{{ route('seeker.jobs.index') }}" class="my-4">
    {{-- 🔍 MAIN SEARCH BAR --}}
    <div class="input-group custom-search-group mb-2">
        <span class="input-group-text bg-white border-0">
            <i class="bi bi-search text-muted"></i>
        </span>
        <input 
            type="text" 
            name="keyword" 
            class="form-control border-0" 
            placeholder="Job title, keywords, or company" 
            value="{{ request('keyword') }}"
        >

        <span class="input-group-text bg-white border-start">
            <i class="bi bi-geo-alt text-muted"></i>
        </span>
        <input 
            type="text" 
            name="location" 
            class="form-control border-0" 
            placeholder='City, state, zip code, or "remote"' 
            value="{{ request('location') }}"
        >

        <button class="btn btn-primary px-4" type="submit">Find jobs</button>
    </div>

    {{-- 🔽 Toggle Button --}}
    <div class="text-end mb-2">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="toggleFilters()">More filters</button>
    </div>

    {{-- 🎛️ ADVANCED FILTERS --}}
    <div id="advanced-filters" style="display: none;" class="bg-light p-3 rounded">
        <div class="row g-2">
            <div class="col-md-3">
                <select name="industry" class="form-control">
                    <option value="">Industry</option>
                    <option value="IT" {{ request('industry') == 'IT' ? 'selected' : '' }}>IT</option>
                    <option value="Finance" {{ request('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                    <option value="Healthcare" {{ request('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-control">
                    <option value="">Job Type</option>
                    <option value="Full-time" {{ request('type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                    <option value="Part-time" {{ request('type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                    <option value="Remote" {{ request('type') == 'Remote' ? 'selected' : '' }}>Remote</option>
                    <option value="Contract" {{ request('type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-control">
                    <option value="">Sort By</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <a href="{{ route('seeker.jobs.index') }}" class="btn btn-outline-danger">Reset All</a>
            </div>
        </div>
    </div>
</form>
{{-- 🔔 Job Alert Button --}}
@if(Auth::check())
    <form method="POST" action="{{ route('seeker.alerts.store') }}">
        @csrf
        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
        <input type="hidden" name="location" value="{{ request('location') }}">
        <input type="hidden" name="industry" value="{{ request('industry') }}">
        <input type="hidden" name="type" value="{{ request('type') }}">
        
        <button class="btn btn-outline-info mt-3">
            🔔 Create Job Alert for this Search
        </button>
    </form>
@endif



<style>
  .custom-search-group {
    border: 1px solid #ccc;
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

</style>
    @forelse ($jobs as $job)
        <div class="card mb-3 p-3">
            <h5>
                <a href="{{ route('seeker.jobs.show', $job->id) }}">{{ $job->title }}</a>
            </h5>
            <p class="mb-1">
                {{ $job->company->name ?? 'Unknown Company' }} | {{ ucfirst($job->type) }}
            </p>
            <p class="text-muted">
                {{ $job->location }} | Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}
            </p>

            {{-- ⭐ Save/Unsave button --}}
            <button 
                class="btn btn-link save-job-btn"
                data-job-id="{{ $job->id }}">
                {{ auth()->user()->savedJobs->contains('id', $job->id) ? '⭐ Saved' : '☆ Save Job' }}
            </button>
        </div>
    @empty
        <p>No jobs found.</p>
    @endforelse

    {{ $jobs->links() }}
@endsection


@section('scripts')
<script>
    document.querySelectorAll('.save-job-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const jobId = this.dataset.jobId;

            fetch(`{{ url('/seeker/saved-jobs/toggle') }}/${jobId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                this.innerText = data.saved ? '⭐ Saved' : '☆ Save Job';
            })
            .catch(error => {
                console.error('Error:', error);
                alert("Failed to save job. Please login.");
            });
        });
    });
</script>
<script>
    function toggleFilters() {
        const box = document.getElementById('advanced-filters');
        box.style.display = box.style.display === 'none' ? 'block' : 'none';
    }

    // Auto-open if any advanced filter is active
    window.addEventListener('DOMContentLoaded', () => {
        @if(request()->filled('industry') || request()->filled('type') || request()->filled('sort'))
            document.getElementById('advanced-filters').style.display = 'block';
        @endif
    });
</script>
@endsection

