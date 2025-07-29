@extends('layouts.app')

@section('title', 'My Applications')

@section('content')
    <div class="container py-4">
        <h4 class="mb-4">📄 My Job Applications</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse ($applications as $application)
            @php
                $companyUserId = $application->job->company->user_id ?? null;

                $lastMessage = \App\Models\Message::where(function ($q) use ($companyUserId) {
                        $q->where('sender_id', auth()->id())->where('receiver_id', $companyUserId);
                    })
                    ->orWhere(function ($q) use ($companyUserId) {
                        $q->where('sender_id', $companyUserId)->where('receiver_id', auth()->id());
                    })
                    ->latest()
                    ->first();

                $unreadCount = \App\Models\Message::where('sender_id', $companyUserId)
                    ->where('receiver_id', auth()->id())
                    ->whereNull('read_at')
                    ->count();
            @endphp

            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $application->job->title }}
                        <span class="text-muted">@ {{ $application->job->company->name ?? 'Unknown Company' }}</span>
                    </h5>

                    <p class="mb-1">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $application->status == 'pending' ? 'secondary' : ($application->status == 'shortlisted' ? 'info' : ($application->status == 'reviewed' ? 'success' : 'danger')) }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </p>

                    <p class="text-muted">🕒 Applied on: {{ $application->created_at->format('M d, Y') }}</p>

                    <a href="{{ asset('storage/' . $application->resume_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                        <i class="bi bi-file-earmark-text me-1"></i> View Resume
                    </a>

                    <a href="{{ route('messages.show', $companyUserId) }}" class="btn btn-sm btn-outline-secondary mt-2 d-block">
                        💬 Chat with Employer
                        @if ($unreadCount > 0)
                            <span class="badge bg-danger ms-2">{{ $unreadCount }} unread</span>
                        @endif

                        @if ($lastMessage)
                            <div class="small text-muted mt-1">
                                {{ Str::limit($lastMessage->message, 50) }}
                                <br>
                                <em>{{ $lastMessage->created_at->diffForHumans() }}</em>
                            </div>
                        @endif
                    </a>
                </div>
            </div>
        @empty
            <p class="text-muted">You haven’t applied for any jobs yet.</p>
        @endforelse

        <div class="mt-3">
            {{ $applications->links() }}
        </div>
    </div>
@endsection
