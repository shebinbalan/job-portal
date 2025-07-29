<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $user->name }} - Resume</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            line-height: 1.6;
            color: #2c3e50;
        }
        h1, h2 {
            color: #2c3e50;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .badge {
            background-color: #3498db;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            margin: 2px;
            display: inline-block;
        }
        a {
            color: #1d68a7;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h1>{{ $user->name }}</h1>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>

    {{-- 🔗 Social Links --}}
    @if ($user->linkedin || $user->github || $user->portfolio)
        <h2>🔗 Social Links</h2>
        <ul>
            @if ($user->linkedin)
                <li>🔗 <strong>LinkedIn:</strong> <a href="{{ $user->linkedin }}" target="_blank">{{ $user->linkedin }}</a></li>
            @endif
            @if ($user->github)
                <li>💻 <strong>GitHub:</strong> <a href="{{ $user->github }}" target="_blank">{{ $user->github }}</a></li>
            @endif
            @if ($user->portfolio)
                <li>🌐 <strong>Portfolio:</strong> <a href="{{ $user->portfolio }}" target="_blank">{{ $user->portfolio }}</a></li>
            @endif
        </ul>
    @endif

    {{-- 🧠 About Me --}}
    @if ($user->about)
        <div class="section">
            <h2>🧠 About Me</h2>
            <p>{{ $user->about }}</p>
        </div>
    @endif

    {{-- 🎓 Education --}}
    @if ($user->education)
        <div class="section">
            <h2>🎓 Education</h2>
            <p>{{ $user->education }}</p>
        </div>
    @endif

    {{-- 💼 Experience --}}
    @if ($user->experience)
        <div class="section">
            <h2>💼 Experience</h2>
            <p>{{ $user->experience }}</p>
        </div>
    @endif

    {{-- 🛠 Skills --}}
    @if ($user->skills)
        <div class="section">
            <h2>🛠 Skills</h2>
            @foreach (explode(',', $user->skills) as $skill)
                <span class="badge">{{ trim($skill) }}</span>
            @endforeach
        </div>
    @endif

</body>
</html>
