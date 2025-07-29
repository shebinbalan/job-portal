@php
    $user = auth()->user();
    $isSaved = $user && $user->savedJobs->contains($job->id);
@endphp

<div class="card mb-3 job-card" data-id="{{ $job->id }}">
    <div class="card-body">
        <h5 class="card-title">{{ $job->title }}</h5>
        <p class="card-text mb-1">
            <strong>{{ $job->company->name ?? 'Company' }}</strong> — {{ $job->location }}
        </p>

        @if($job->type)
            <span class="badge bg-info text-dark">{{ ucfirst($job->type) }}</span>
        @endif

        <div class="mt-3 d-flex align-items-center gap-2">
            {{-- 🔍 Preview Button --}}
            <button type="button"
                    class="btn btn-sm btn-outline-primary btn-preview"
                    data-id="{{ $job->id }}"
                    data-bs-toggle="modal"
                    data-bs-target="#jobPreviewModal">
                👁️ Preview
            </button>

            {{-- 🔗 View Job --}}
            <a href="{{ route('seeker.jobs.show', $job) }}" class="btn btn-sm btn-primary">View Job</a>

            {{-- 💾 Save/Unsave --}}
            @auth
                <button type="button"
                        class="btn btn-sm btn-toggle-save {{ $isSaved ? 'btn-outline-danger' : 'btn-outline-secondary' }}"
                        data-id="{{ $job->id }}">
                    {{ $isSaved ? 'Unsave' : 'Save' }}
                </button>
            @endauth
        </div>
    </div>
</div>
