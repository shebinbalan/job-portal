@extends('employer-layout.app')

@section('title', 'Job Listings')
@section('header', 'Your Job Posts')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4 text-end">
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Post New Job
        </a>
    </div>

    @if($jobs->isEmpty())
        <div class="card p-4 text-center shadow-sm">
            <p class="mb-0">No job postings yet.</p>
        </div>
    @else
        <div class="table-responsive shadow-sm">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->location }}</td>
                            <td>
                                <span class="badge bg-secondary text-capitalize">{{ $job->type }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</td>
                            <td>
                                @if($job->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('employer.jobs.show', $job) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('employer.jobs.edit', $job) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('employer.jobs.destroy', $job) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <form action="{{ route('employer.jobs.duplicate', $job->id) }}" method="POST" class="d-inline">
    @csrf
    <button class="btn btn-sm btn-outline-warning" onclick="return confirm('Duplicate this job?')">
        📝 Duplicate
    </button>
</form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
