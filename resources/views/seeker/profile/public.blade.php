@extends('employer-layout.app')

@section('title', 'View Profile')
@section('header', 'View Profile')

@section('content')
<div class="container py-4">

    {{-- Profile Card --}}
    <div class="card shadow-sm p-4 mb-4">
        <div class="d-flex align-items-center">
            {{-- 📸 Avatar --}}
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}"
                     class="rounded-circle me-4" width="100" height="100" alt="Profile Photo">
            @else
                <div class="bg-secondary rounded-circle text-white d-flex align-items-center justify-content-center me-4" style="width: 100px; height: 100px;">
                    <strong class="fs-3">{{ strtoupper(substr($user->name, 0, 1)) }}</strong>
                </div>
            @endif

            <div>
                <h3 class="mb-0">{{ $user->name }}</h3>
                <p class="text-muted mb-1"><i class="bi bi-envelope"></i> {{ $user->email }}</p>
                <p class="text-muted"><i class="bi bi-telephone"></i> {{ $user->phone ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    {{-- Resume --}}
    @if ($user->resume_path)
        <div class="card shadow-sm p-3 mb-4">
            <h5><i class="bi bi-file-earmark-text me-2"></i>Resume</h5>
            <a href="{{ asset('storage/' . $user->resume_path) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">
                📄 View Resume
            </a>
        </div>
    @endif

    {{-- Skills --}}
    @if ($user->skills)
        <div class="card shadow-sm p-3 mb-4">
            <h5><i class="bi bi-lightbulb me-2"></i>Skills</h5>
            <div>
                @foreach(explode(',', $user->skills) as $skill)
                    <span class="badge bg-secondary me-1 mb-1">{{ trim($skill) }}</span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- About Me --}}
    @if ($user->about)
        <div class="card shadow-sm p-3 mb-4">
            <h5><i class="bi bi-person-lines-fill me-2"></i>About Me</h5>
            <p class="mb-0">{{ $user->about }}</p>
        </div>
    @endif

    {{-- Experience --}}
    @if ($user->experience)
        <div class="card shadow-sm p-3 mb-4">
            <h5><i class="bi bi-briefcase me-2"></i>Experience</h5>
            <p class="mb-0">{{ $user->experience }}</p>
        </div>
    @endif

    {{-- Education --}}
    @if ($user->education)
        <div class="card shadow-sm p-3 mb-4">
            <h5><i class="bi bi-mortarboard me-2"></i>Education</h5>
            <p class="mb-0">{{ $user->education }}</p>
        </div>
    @endif

    {{-- Download as PDF --}}
    <div class="text-end mt-4">
        <a href="{{ route('employer.seeker.profile.download.pdf', $user->id) }}" class="btn btn-outline-dark">
            ⬇️ Download Profile as PDF
        </a>
    </div>
<form method="POST" action="{{ route('employer.bookmarks.toggle', $user->id) }}">
    @csrf
    <button class="btn btn-sm btn-outline-warning">
        ⭐ {{ auth()->user()->bookmarkedSeekers->contains($user->id) ? 'Unbookmark' : 'Bookmark' }}
    </button>
</form>
</div>

@endsection
