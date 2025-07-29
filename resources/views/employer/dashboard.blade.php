@extends('employer-layout.app')

@section('title', 'Dashboard')
@section('header', 'Analytics Dashboard')

@section('content')
<form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
        <input type="date" name="from" value="{{ $from }}" class="form-control" placeholder="From Date">
    </div>
    <div class="col-md-3">
        <input type="date" name="to" value="{{ $to }}" class="form-control" placeholder="To Date">
    </div>
    <div class="col-md-4">
        <select name="job_id" class="form-select">
            <option value="">All Jobs</option>
            @foreach ($applicationsPerJob as $jobRow)
                <option value="{{ $jobRow->job_id }}" {{ $filterJobId == $jobRow->job_id ? 'selected' : '' }}>
                    {{ $jobRow->job->title ?? 'Unknown' }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <h6>Total Applications</h6>
            <h3>{{ $totalApplications }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm p-3">
            <h6>Bookmarked Seekers</h6>
            <h3>{{ $bookmarkedCount }}</h3>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h6>Status Breakdown</h6>
            <canvas id="statusChart" height="100"></canvas>
        </div>
    </div>
</div>

<div class="card shadow-sm p-3 mb-4">
    <h5 class="mb-3">Applications per Job</h5>
    <ul class="list-group list-group-flush">
        @foreach ($applicationsPerJob as $item)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $item->job->title ?? 'Unknown Job' }}</span>
                <span class="badge bg-primary">{{ $item->count }}</span>
            </li>
        @endforeach
    </ul>
</div>

<div class="card shadow-sm p-3">
    <h5 class="mb-3">Application Trends Over Time</h5>
    <canvas id="applicationsChart" height="100"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const appCtx = document.getElementById('applicationsChart').getContext('2d');
    new Chart(appCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Applications',
                data: {!! json_encode($chartData) !!},
                borderColor: 'blue',
                backgroundColor: 'rgba(0, 0, 255, 0.1)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: { title: { display: true, text: 'Date' }},
                y: { beginAtZero: true, title: { display: true, text: 'Count' }}
            }
        }
    });

    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($statusBreakdown->toArray())) !!},
            datasets: [{
                label: 'Status',
                data: {!! json_encode(array_values($statusBreakdown->toArray())) !!},
                backgroundColor: ['#f39c12', '#3498db', '#2ecc71', '#e74c3c']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection
