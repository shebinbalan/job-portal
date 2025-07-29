<!DOCTYPE html>
<html>
<head>
    <title>{{ $user->name }} - Profile PDF</title>
    <style>
        body { font-family: sans-serif; }
        .badge { display: inline-block; padding: 3px 8px; background: #ccc; border-radius: 4px; margin-right: 5px; }
    </style>
</head>
<body>
    <h2>{{ $user->name }}</h2>
    <p>Email: {{ $user->email }}</p>
    <p>Phone: {{ $user->phone ?? 'N/A' }}</p>

    @if ($user->skills)
        <p><strong>Skills:</strong><br>
            @foreach(explode(',', $user->skills) as $skill)
                <span class="badge">{{ trim($skill) }}</span>
            @endforeach
        </p>
    @endif

    @if ($user->about)
        <p><strong>About Me:</strong><br>{{ $user->about }}</p>
    @endif

    @if ($user->experience)
        <p><strong>Experience:</strong><br>{{ $user->experience }}</p>
    @endif

    @if ($user->education)
        <p><strong>Education:</strong><br>{{ $user->education }}</p>
    @endif
</body>
</html>
