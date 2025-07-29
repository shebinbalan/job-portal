<?php

namespace App\Http\Controllers;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
   public function show(User $user)
    {
        $messages = Message::where(function ($q) use ($user) {
                $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            $layout = auth()->user()->isEmployer() ? 'employer-layout.app' : 'layouts.app';
            return view('messages.chat', compact('user', 'messages', 'layout')); // 🔁 include $layout
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'message' => $request->message,
        ]);

        return redirect()->route('messages.show', $user);
    }
}
