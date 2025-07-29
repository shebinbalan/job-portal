@extends($layout)

@section('title', 'Chat with ' . $user->name)
@section('header', 'Conversation with ' . $user->name) 


@section('content')
    <div class="card mb-3 p-3" style="max-height: 400px; overflow-y: auto;">
        @foreach ($messages as $msg)
            <div class="mb-2 {{ $msg->sender_id === auth()->id() ? 'text-end' : 'text-start' }}">
                <div class="p-2 rounded 
                    {{ $msg->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                    <strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}
                </div>
                <div class="text-muted small">
                    {{ $msg->created_at->diffForHumans() }}
                </div>
            </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('messages.store', $user) }}">
        @csrf
        <div class="input-group mt-3">
            <input type="text" name="message" class="form-control" placeholder="Type a message..." required>
            <button class="btn btn-primary">Send</button>
        </div>
    </form>
@endsection

