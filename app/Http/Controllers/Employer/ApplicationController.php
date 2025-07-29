<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with(['job', 'user'])
            ->whereHas('job', function ($query) {
                $query->where('company_id', Auth::user()->company->id);
            })
            ->latest()
            ->paginate(10);

        return view('employer.applications.index', compact('applications'));
    }

    public function updateStatus(Request $request, JobApplication $application)
{
    $request->validate([
        'status' => 'required|in:pending,reviewed,shortlisted,rejected'
    ]);

    $application->status = $request->status;
    $application->save();

    return redirect()->back()->with('success', 'Application status updated.');
}

public function sendMessage(Request $request, JobApplication $application)
{
    $request->validate([
        'message' => 'required|string|max:5000',
    ]);

    Message::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $application->user_id,
        'message' => $request->message,
    ]);

    return redirect()->back()->with('success', 'Message sent to applicant.');
}
}
