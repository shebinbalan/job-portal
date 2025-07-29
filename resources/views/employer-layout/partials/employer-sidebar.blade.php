<nav class="col-md-3 col-lg-2 d-md-block bg-white border-end shadow-sm sidebar py-4 px-3">
    <div class="position-sticky">
        <h5 class="text-primary fw-bold mb-4">
            <i class="bi bi-person-badge-fill me-2"></i>Employer Panel
        </h5>
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a href="{{ route('employer.dashboard') }}"
                   class="nav-link px-3 py-2 rounded {{ request()->routeIs('employer.dashboard') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <!-- Company -->
            <li class="nav-item mb-2">
                <a href="{{ route('employer.company.index') }}"
                   class="nav-link px-3 py-2 rounded {{ request()->routeIs('employer.company.index') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
                    <i class="bi bi-building me-2"></i> Company
                </a>
            </li>

            <li class="nav-item mb-2">
    <a href="{{ route('employer.applications.index') }}"
       class="nav-link px-3 py-2 rounded {{ request()->routeIs('employer.applications.index') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
        <i class="bi bi-inbox me-2"></i> Applications
    </a>
</li>

  <li class="nav-item mb-2">
    <a href="{{ route('employer.bookmarks.index') }}"
       class="nav-link px-3 py-2 rounded {{ request()->routeIs('employer.bookmarks.index') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
        <i class="bi bi-bookmark-fill "></i> Book Marks
    </a>
</li>

            <!-- Jobs (coming soon) -->
            <li class="nav-item mb-2">
                <a href="{{ route('employer.jobs.index') }}" class="nav-link px-3 py-2 rounded {{ request()->routeIs('employer.company.index') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect ">
                    <i class="bi bi-briefcase me-2"></i> Jobs
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
<style>
    .hover-effect:hover {
    background-color: #f0f4ff;
    color: #0d6efd !important;
    font-weight: 500;
    transition: all 0.2s ease-in-out;
}
</style>