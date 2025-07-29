<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $user->name }} – Resume</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #1e1e2f;
            color: #ffffff;
            padding: 30px;
        }
        h1, h2 {
            border-bottom: 1px solid #444;
            color: #66ccff;
        }
        .section {
            margin-top: 25px;
        }
        .skills span {
            background-color: #333;
            padding: 5px 10px;
            margin: 3px;
            border-radius: 5px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>{{ $user->name }}</h1>
    <p>Email: {{ $user->email }} | Phone: {{ $user->phone }}</p>

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

    <div class="section">
        <h2>Skills</h2>
        @foreach(explode(',', $user->skills) as $skill)
            <span>{{ trim($skill) }}</span>
        @endforeach
    </div>
</body>
</html>
