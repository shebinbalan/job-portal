<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Job Seeker Portal')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('seeker.dashboard') }}">🎯 JobSeeker</a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a href="{{ route('seeker.jobs.index') }}"
                       class="nav-link {{ request()->routeIs('seeker.jobs.*') ? 'fw-bold text-primary' : '' }}">
                        <i class="bi bi-briefcase me-1"></i> Jobs
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('seeker.applications.index') }}"
                       class="nav-link {{ request()->routeIs('seeker.applications.*') ? 'fw-bold text-primary' : '' }}">
                        <i class="bi bi-file-earmark-check me-1"></i> My Applications
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('seeker.profile.edit') }}" class="nav-link">
                        <i class="bi bi-person-lines-fill me-1"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('seeker.resume.edit') }}" class="nav-link">
                        <i class="bi bi-file-earmark-text me-1"></i> Resume
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('seeker.saved-jobs.index') }}" class="nav-link">
                        <i class="bi bi-bookmark-heart me-1"></i> Saved Jobs
                    </a>
                </li>
                <li class="nav-item">
                <a href="{{ route('seeker.alerts.index') }}" class="nav-link">
                    <i class="bi bi-bell me-1"></i> Alerts
                </a>
            </li>
             <li class="nav-item">
                <a href="{{ route('seeker.cover-letters.index') }}" class="nav-link">
                    <i class="bi bi-bell me-1"></i> Cover Letters
                </a>
            </li>
            </ul>

            <div class="d-flex">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>


    <!-- Page Content -->
    <div class="container py-4">
        <h2 class="mb-4">@yield('header')</h2>

        @include('components.flash-messages')

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
