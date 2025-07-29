@extends('employer-layout.app')

@section('title', 'Job Applications')
@section('header', 'Incoming Applications')

@section('content')
@forelse ($applications as $application)
    <div class="card mb-4 p-3 shadow-sm">
        <h5 class="mb-1">
            {{ $application->job->title }} — 
            <span class="text-primary">{{ $application->user->name }}</span>
        </h5>

        <p class="mb-1">
            <strong>Status:</strong> 
            <span class="badge bg-secondary">{{ ucfirst($application->status) }}</span>
        </p>

        <p class="mb-1 text-muted">
            <i class="bi bi-clock me-1"></i>
            Applied on: {{ $application->created_at->format('M d, Y') }}
        </p>

        @if ($application->cover_letter)
            <p class="mb-2">
                <strong>Cover Letter:</strong><br>
                {{ Str::limit($application->cover_letter, 150) }}
            </p>
        @endif

        <div class="d-flex flex-column flex-md-row gap-2 align-items-start align-items-md-center">
    <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
        📄 View Resume
    </a>

    <a href="{{ route('messages.show', $application->user->id) }}" class="btn btn-sm btn-outline-secondary">
        💬 View Chat
    </a>

    <a href="{{ route('seeker.public.profile', $application->user->id) }}" class="btn btn-sm btn-outline-info">
        👤 View Seeker Profile
    </a>

    <!-- Status Dropdown -->
    <form method="POST" action="{{ route('employer.applications.updateStatus', $application) }}">
        @csrf
        @method('PATCH')
        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
            @foreach(['pending', 'reviewed', 'shortlisted', 'rejected'] as $status)
                <option value="{{ $status }}" {{ $application->status === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </form>
</div>

        <!-- ✅ Message Form -->
        <form method="POST" action="{{ route('employer.applications.message', $application) }}" class="mt-3">
            @csrf
            <div class="input-group input-group-sm">
                <input type="text" name="message" class="form-control" placeholder="Send message to applicant..." required>
                <button class="btn btn-primary">Send</button>
            </div>
        </form>
    </div>
@empty
    <div class="alert alert-info">No applications received yet.</div>
@endforelse


    <div class="mt-4">
        {{ $applications->links() }}
    </div>
@endsection
