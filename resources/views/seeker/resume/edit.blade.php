@extends('layouts.app')

@section('title', 'Resume Builder')

@section('content')
<div class="container py-4">
    <h3>🧾 Resume Builder</h3>

    {{-- Username warning --}}
    @if (!$user->username)
        <div class="alert alert-warning">
            ⚠️ To enable public sharing, please set a <strong>username</strong> in your 
            <a href="{{ route('seeker.profile.edit') }}">profile settings</a>.
        </div>
    @endif

    <form method="POST" action="{{ route('seeker.resume.update') }}">
        @csrf
            <div class="mb-3">
                <label>LinkedIn</label>
                <input type="url" name="linkedin" class="form-control" value="{{ old('linkedin', $user->linkedin) }}">
            </div>

            <div class="mb-3">
                <label>GitHub</label>
                <input type="url" name="github" class="form-control" value="{{ old('github', $user->github) }}">
            </div>

            <div class="mb-3">
                <label>Portfolio Website</label>
                <input type="url" name="portfolio" class="form-control" value="{{ old('portfolio', $user->portfolio) }}">
            </div>

        <div class="mb-3">
            <label>About Me</label>
            <textarea name="about" class="form-control" rows="3">{{ old('about', $user->about) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Education</label>
            <textarea name="education" class="form-control" rows="3">{{ old('education', $user->education) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Experience</label>
            <textarea name="experience" class="form-control" rows="3">{{ old('experience', $user->experience) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Skills <small class="text-muted">(comma-separated)</small></label>
            <input name="skills" class="form-control" value="{{ old('skills', $user->skills) }}">
            <small class="form-text text-muted">e.g. Laravel, Vue.js, Communication</small>
        </div>

        <div class="mb-3">
            <label>Template Style</label>
            <select name="resume_template" class="form-select">
                <option value="basic"   {{ $user->resume_template == 'basic' ? 'selected' : '' }}>Basic</option>
                <option value="modern"  {{ $user->resume_template == 'modern' ? 'selected' : '' }}>Modern</option>
                <option value="elegant" {{ $user->resume_template == 'elegant' ? 'selected' : '' }}>Elegant</option>
                <option value="dark"    {{ $user->resume_template == 'dark' ? 'selected' : '' }}>Dark Mode</option>
                <option value="onepage" {{ $user->resume_template == 'onepage' ? 'selected' : '' }}>One Page</option>
                <option value="ats"     {{ $user->resume_template == 'ats' ? 'selected' : '' }}>ATS-Friendly</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="resume_visibility" class="form-check-input" id="visibilityCheckbox"
                   {{ $user->resume_visibility ? 'checked' : '' }} value="1">
            <label class="form-check-label" for="visibilityCheckbox">Make my resume public (sharable)</label>
        </div>

        @if ($user->resume_visibility && $user->username)
            <div class="mb-3">
                🌍 <strong>Public Resume Link:</strong>
                <a href="{{ route('seeker.resume.public', $user->username) }}" target="_blank">
                    {{ route('seeker.resume.public', $user->username) }}
                </a>
            </div>
        @endif

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">💾 Save Resume</button>
            <a href="{{ route('seeker.resume.download') }}" class="btn btn-outline-dark">⬇️ Download as PDF</a>
        </div>
    </form>
</div>

<hr class="my-5">

<h4>📎 Upload Certificates</h4>

<form method="POST" action="{{ route('seeker.certificates.store') }}" enctype="multipart/form-data" class="mb-4">
    @csrf
    <div class="mb-2">
        <label>Certificate Title</label>
        <input name="title" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Upload File (PDF/Image)</label>
        <input type="file" name="certificate" class="form-control" required>
    </div>
    <button class="btn btn-sm btn-primary">📎 Upload Certificate</button>
</form>

@if($user->certificates->count())
    <div class="mt-4">
        <h5>📎 Uploaded Certificates</h5>
        <ul class="list-group">
            @foreach($user->certificates as $certificate)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $certificate->title }}
                    <div>
                        <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">🔗 View</a>

                        {{-- Delete Form --}}
                        <form method="POST" action="{{ route('seeker.certificates.destroy', $certificate->id) }}" class="d-inline-block" onsubmit="return confirm('Delete this certificate?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">🗑 Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
