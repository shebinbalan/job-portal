@extends('admin-layout.app')

@section('title', 'Company Management')
@section('header', 'Companies')

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Name</th>
                <th>Website</th>
                <th>Employer</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>
                        @if($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" width="50">
                        @endif
                    </td>
                    <td>{{ $company->name }}</td>
                    <td><a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></td>
                    <td>{{ $company->employer->name ?? 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $company->is_verified ? 'success' : 'secondary' }}">
                            {{ $company->is_verified ? 'Verified' : 'Unverified' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
