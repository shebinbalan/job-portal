@extends('layouts.app')

@section('title', 'Apply to ' )

@section('content')
   <h3>My Cover Letter Templates</h3>

<form method="POST" action="{{ route('seeker.cover-letters.store') }}">
    @csrf
    <div class="mb-2">
        <input type="text" name="title" class="form-control" placeholder="Template Title" required>
    </div>
    <div class="mb-2">
        <textarea name="content" class="form-control" rows="6" placeholder="Cover letter content..." required></textarea>
    </div>
    <button class="btn btn-primary">Save Template</button>
</form>

<hr>

@foreach($templates as $template)
    <div class="border p-3 my-2">
        <strong>{{ $template->title }}</strong>
        <p>{{ Str::limit($template->content, 100) }}</p>
        <form method="POST" action="{{ route('seeker.cover-letters.destroy', $template) }}">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger">Delete</button>
        </form>
    </div>
@endforeach

@endsection
