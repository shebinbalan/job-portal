@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h4>My Job Alerts</h4>

    <form action="{{ route('seeker.alerts.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control" placeholder="Keyword" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="location" class="form-control" placeholder="Location">
            </div>
            <div class="col-md-3">
                <input type="text" name="industry" class="form-control" placeholder="Industry">
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select">
                    <option value="">Any Type</option>
                    <option value="full-time">Full-Time</option>
                    <option value="part-time">Part-Time</option>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-success w-100">Add</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Keyword</th>
                <th>Location</th>
                <th>Industry</th>
                <th>Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($alerts as $alert)
            <tr>
                <td>{{ $alert->keyword }}</td>
                <td>{{ $alert->location }}</td>
                <td>{{ $alert->industry }}</td>
                <td>{{ ucfirst($alert->type) }}</td>
                <td>
                    <form action="{{ route('seeker.alerts.toggle', $alert) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm {{ $alert->enabled ? 'btn-success' : 'btn-secondary' }}">
                            {{ $alert->enabled ? 'Enabled' : 'Disabled' }}
                        </button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('seeker.alerts.destroy', $alert->id) }}" method="POST" onsubmit="return confirm('Delete this alert?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">🗑</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">No alerts found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
