<nav class="col-md-3 col-lg-2 d-md-block bg-white border-end shadow-sm sidebar py-4 px-3">
    <div class="position-sticky">
        <h5 class="text-primary fw-bold mb-4">
            <i class="bi bi-person-lock me-2"></i> Admin Panel
        </h5>
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link px-3 py-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <!-- User Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.users.index') }}"
                   class="nav-link px-3 py-2 rounded {{ request()->routeIs('admin.users.index') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>

            <!-- Company Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.companies.index') }}"
                   class="nav-link px-3 py-2 rounded {{ request()->routeIs('admin.companies.index') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
                    <i class="bi bi-buildings me-2"></i> Companies
                </a>
            </li>

            <!-- Job Management -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.jobs.index') }}"
                   class="nav-link px-3 py-2 rounded {{ request()->routeIs('admin.jobs.index') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
                    <i class="bi bi-briefcase-fill me-2"></i> Jobs
                </a>
            </li>

            <!-- Categories -->
            <li class="nav-item mb-2">
                <a href="{{ route('admin.categories.index') }}"
                   class="nav-link px-3 py-2 rounded {{ request()->routeIs('admin.categories.index') ? 'bg-primary text-white fw-semibold' : 'text-dark' }} hover-effect">
                    <i class="bi bi-tags-fill me-2"></i> Categories
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
