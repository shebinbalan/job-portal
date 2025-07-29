<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $user->name }} – Resume</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background: #fdfdfd;
            color: #333;
            margin: 40px;
        }
        h1, h2 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }
        .section {
            margin-top: 30px;
        }
        .skills {
            margin-top: 10px;
        }
        .skills span {
            font-style: italic;
            margin-right: 10px;
            padding: 3px 8px;
            border: 1px solid #aaa;
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

    <div class="section skills">
        <h2>Skills</h2>
        @foreach(explode(',', $user->skills) as $skill)
            <span>{{ trim($skill) }}</span>
        @endforeach
    </div>
</body>
</html>
