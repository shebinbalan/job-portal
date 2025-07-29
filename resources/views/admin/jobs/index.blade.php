@extends('admin-layout.app')

@section('title', 'Job Posts')
@section('header', 'Job Management')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Job Title</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Deadline</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>{{ $job->id }}</td>
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->company->name ?? 'N/A' }}</td>
                        <td>{{ $job->location }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($job->type) }}</span></td>
                        <td>
                            @if($job->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No job posts available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
