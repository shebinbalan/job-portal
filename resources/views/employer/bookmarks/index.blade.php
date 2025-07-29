@extends('employer-layout.app')

@section('title', 'Bookmarked Seekers')
@section('header', '⭐ My Bookmarked Seekers')



@section('content')
    <h3></h3>

    @forelse ($bookmarks as $seeker)
        <div class="card mb-3 p-3">
            <h5>{{ $seeker->name }}</h5>
            <p>{{ $seeker->email }}</p>
            <a href="{{ route('seeker.public.profile', $seeker->id) }}" class="btn btn-sm btn-outline-info">
                👤 View Profile
            </a>
        </div>
    @empty
        <p>No seekers bookmarked yet.</p>
    @endforelse
@endsection
