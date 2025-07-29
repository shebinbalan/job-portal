<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume</title>
    <style>
        body { font-family: sans-serif; }
        h3 { border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        .section { margin-bottom: 20px; }
    </style>
</head>
<body>
    <ul>
    @if ($user->linkedin)
        <li><strong>LinkedIn:</strong> <a href="{{ $user->linkedin }}" target="_blank">{{ $user->linkedin }}</a></li>
    @endif
    @if ($user->github)
        <li><strong>GitHub:</strong> <a href="{{ $user->github }}" target="_blank">{{ $user->github }}</a></li>
    @endif
    @if ($user->portfolio)
        <li><strong>Portfolio:</strong> <a href="{{ $user->portfolio }}" target="_blank">{{ $user->portfolio }}</a></li>
    @endif
</ul>
    <h2>{{ $user->name }}</h2>
    <p>Email: {{ $user->email }}</p>
    <p>Phone: {{ $user->phone }}</p>

    @if ($user->about)
    <div class="section">
        <h3>About Me</h3>
        <p>{{ $user->about }}</p>
    </div>
    @endif

    @if ($user->education)
    <div class="section">
        <h3>Education</h3>
        <p>{{ $user->education }}</p>
    </div>
    @endif

    @if ($user->experience)
    <div class="section">
        <h3>Experience</h3>
        <p>{{ $user->experience }}</p>
    </div>
    @endif

    @if ($user->skills)
    <div class="section">
        <h3>Skills</h3>
        <ul>
            @foreach(explode(',', $user->skills) as $skill)
                <li>{{ trim($skill) }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</body>
</html>
