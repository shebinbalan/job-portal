@extends('admin-layout.app')

@section('title', 'Admin Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="alert alert-info">
        Welcome to the Admin Dashboard!
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Manage registered users.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Companies</h5>
                    <p class="card-text">View and verify employer companies.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Jobs</h5>
                    <p class="card-text">Moderate job listings.</p>
                </div>
            </div>
        </div>
    </div>
    {{-- 📈 User Registration Trend --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5>User Registrations (Daily)</h5>
        <canvas id="userTrendChart" height="100"></canvas>
    </div>
</div>

{{-- 📊 Jobs per Category --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5>Jobs by Category</h5>
        <canvas id="jobsPerCategoryChart" height="100"></canvas>
    </div>
</div>

{{-- 🕑 Recent Jobs --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5>Recently Posted Jobs</h5>
        <ul class="list-group list-group-flush">
            @foreach ($recentJobs as $job)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $job->title }}</span>
                    <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- 👥 Recently Registered Users --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5>Recently Registered Users</h5>
        <ul class="list-group list-group-flush">
            @foreach ($recentUsers as $user)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $user->name }} ({{ ucfirst($user->role) }})</span>
                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 📈 User Registration Trend
    const userCtx = document.getElementById('userTrendChart').getContext('2d');
    new Chart(userCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($userTrend->pluck('date')) !!},
            datasets: [{
                label: 'Users',
                data: {!! json_encode($userTrend->pluck('count')) !!},
                borderColor: 'blue',
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                x: { title: { display: true, text: 'Date' }},
                y: { beginAtZero: true }
            }
        }
    });

    // 📊 Jobs Per Category
    const categoryCtx = document.getElementById('jobsPerCategoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($jobsPerCategory->pluck('name')) !!},
            datasets: [{
                label: 'Jobs',
                data: {!! json_encode($jobsPerCategory->pluck('jobs_count')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
</script>
@endsection


