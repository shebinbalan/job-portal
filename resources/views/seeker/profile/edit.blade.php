@extends('layouts.app')

@section('title', 'Edit Profile')
@section('content')
<div class="container py-4">
    <h4 class="mb-4">✏️ Edit Profile</h4>

  

    <form method="POST" action="{{ route('seeker.profile.update') }}" enctype="multipart/form-data">
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
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
        </div>

            <div class="mb-3">
        <label>Profile Photo</label>
        <input type="file" name="avatar" class="form-control">
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" class="img-thumbnail mt-2" width="100">
        @endif
    </div>

        <div class="mb-3">
            <label for="skills" class="form-label">Skills</label>
            <input type="text" name="skills" id="skills" value="{{ old('skills', $user->skills) }}" class="form-control" placeholder="e.g. PHP, Laravel, Vue.js">
            <small class="text-muted">Enter comma-separated values like: HTML, CSS, React</small>
        </div>

        <div class="mb-3">
            <label>Resume (PDF or DOC)</label>
            <input type="file" name="resume" class="form-control">
            @if($user->resume_path)
                <a href="{{ asset('storage/' . $user->resume_path) }}" class="btn btn-sm btn-outline-primary mt-2" target="_blank">
                    📄 View Current Resume
                </a>
            @endif
        </div>
<div class="mb-3">
            <label>About</label>
            <textarea name="about" class="form-control">{{ old('about', $user->about) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Experience</label>
           <textarea name="experience" class="form-control">{{ old('experience', $user->experience) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Education</label>
           <textarea name="education" class="form-control">{{ old('education', $user->education) }}</textarea>
        </div>
        <button class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
