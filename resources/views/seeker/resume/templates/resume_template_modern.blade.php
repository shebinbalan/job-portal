<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $user->name }} – Resume</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        h1 { color: #333; border-bottom: 2px solid #444; padding-bottom: 5px; }
        .section { margin-bottom: 25px; }
        .section h2 { color: #007BFF; margin-bottom: 8px; }
        .skills span { background: #007BFF; color: #fff; padding: 5px 10px; border-radius: 5px; margin-right: 5px; display: inline-block; margin-top: 5px; }
    </style>
</head>
<body>
    <h1>{{ $user->name }}</h1>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Phone:</strong> {{ $user->phone }}</p>

    <div class="section">
        <h2>About Me</h2>
        <p>{{ $user->about }}</p>
    </div>

    <div class="section">
        <h2>Education</h2>
        <p>{{ $user->education }}</p>
    </div>

    <div class="section">
        <h2>Experience</h2>
        <p>{{ $user->experience }}</p>
    </div>

    <div class="section skills">
        <h2>Skills</h2>
        @foreach(explode(',', $user->skills) as $skill)
            <span>{{ trim($skill) }}</span>
        @endforeach
    </div>
</body>
</html>
