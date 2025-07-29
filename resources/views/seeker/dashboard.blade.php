@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    {{-- 🔍 Filters --}}
    <form method="GET" action="{{ route('seeker.dashboard') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="location" class="form-control" placeholder="Location" value="{{ request('location') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">🔍 Filter</button>
            </div>
        </div>
    </form>

    {{-- 🔽 Accordion --}}
    <div class="accordion" id="dashboardAccordion">

        {{-- 🧠 Recommended --}}
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="headingRecommended">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRecommended">
                    🧠 Jobs You May Like
                </button>
            </h2>
            <div id="collapseRecommended" class="accordion-collapse collapse show" data-bs-parent="#dashboardAccordion">
                <div class="accordion-body" id="recommended-section">
                    @foreach($recommendedJobs as $job)
                        @include('partials.job-card', ['job' => $job])
                    @endforeach
                </div>
                <div id="recommended-loader" class="text-center py-2 d-none">
                    <span class="spinner-border text-primary"></span>
                </div>
            </div>
        </div>

        {{-- 📌 Saved --}}
        <div class="accordion-item mb-3">
            <h2 class="accordion-header" id="headingSaved">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSaved">
                    📌 Saved Jobs
                </button>
            </h2>
            <div id="collapseSaved" class="accordion-collapse collapse" data-bs-parent="#dashboardAccordion">
                <div class="accordion-body">
                    @forelse($savedJobs as $job)
                        @include('partials.job-card', ['job' => $job, 'saved' => true])
                    @empty
                        <div class="text-muted">No saved jobs.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ✅ Applied --}}
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingApplied">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseApplied">
                    ✅ Applied Jobs
                </button>
            </h2>
            <div id="collapseApplied" class="accordion-collapse collapse" data-bs-parent="#dashboardAccordion">
                <div class="accordion-body">
                    @forelse($appliedJobs as $job)
                        @include('partials.job-card', ['job' => $job])
                    @empty
                        <div class="text-muted">No applications submitted.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
    <!-- 🔍 Job Preview Modal -->
<!-- Job Preview Modal -->
<div class="modal fade" id="jobPreviewModal" tabindex="-1" aria-labelledby="jobPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobPreviewModalLabel">Job Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="jobPreviewContent">
                <!-- AJAX content will load here -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
let page = 2;
let loading = false;

function loadMoreRecommended() {
    if (loading) return;

    loading = true;
    $('#recommended-loader').removeClass('d-none');

    $.get(`{{ route('seeker.dashboard') }}/load-more?page=${page}`, {
        category: '{{ request('category') }}',
        location: '{{ request('location') }}',
    }).then(res => {
        if (res.trim().length > 0) {
            $('#recommended-section').append(res);
            page++;
        }
    }).always(() => {
        $('#recommended-loader').addClass('d-none');
        loading = false;
    });
}




document.addEventListener('DOMContentLoaded', function () {
    // 🔁 Save/Unsave
    document.querySelectorAll('.btn-toggle-save').forEach(button => {
        button.addEventListener('click', function () {
            const jobId = this.dataset.id;

            fetch(`/seeker/jobs/${jobId}/toggle-save`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.textContent = data.saved ? 'Unsave' : 'Save';
                this.classList.toggle('btn-outline-danger', data.saved);
                this.classList.toggle('btn-outline-secondary', !data.saved);
            });
        });
    });

    // 👁️ Preview Modal
    document.querySelectorAll('.btn-preview').forEach(button => {
        button.addEventListener('click', function () {
            const jobId = this.dataset.id;
            const modalBody = document.getElementById('jobPreviewContent');

            modalBody.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

            fetch(`/seeker/jobs/${jobId}/preview`)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                })
                .catch(() => {
                    modalBody.innerHTML = '<p class="text-danger">Failed to load preview.</p>';
                });
        });
    });
});
</script>
@endsection
