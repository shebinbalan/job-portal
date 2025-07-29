<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class JobApplicationController extends Controller
{

    public function index()
{
    $applications = JobApplication::with('job.company')
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10); // ✅ Use paginate instead of get()

    return view('seeker.applications.index', compact('applications'));
}

    public function create(Job $job)
    {
        return view('seeker.applications.apply', compact('job'));
    }

    public function store(Request $request, Job $job)
{
    // ✅ Validate the request
    $request->validate([
        'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'cover_letter' => 'nullable|string|max:5000',
        'cover_letter_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    // ✅ Prevent duplicate application
    $alreadyApplied = JobApplication::where('user_id', auth()->id())
        ->where('job_id', $job->id)
        ->exists();

    if ($alreadyApplied) {
        return redirect()->back()->with('error', 'You have already applied for this job.');
    }

    $coverLetterPath = null;
    if ($request->hasFile('cover_letter_file')) {
        $coverLetterPath = $request->file('cover_letter_file')->store('cover_letters', 'public');
    }

    // ✅ Upload resume
    $path = $request->file('resume')->store('resumes', 'public');

    // ✅ Store application
    JobApplication::create([
        'user_id' => auth()->id(),
        'job_id' => $job->id,
        'resume_path' => $path,
        'cover_letter' => $request->cover_letter,
        'cover_letter_file' => $coverLetterPath,
    ]);

    return redirect()->route('seeker.jobs.show', $job)
        ->with('success', 'Application submitted successfully.');
}

}
