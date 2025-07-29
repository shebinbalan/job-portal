<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobSeekerController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company')
                   ->where('is_active', true)
                   ->latest()
                   ->get();

        return view('seeker.jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        return view('seeker.jobs.show', compact('job'));
    }

    public function editProfile()
{
    $user = auth()->user();
    return view('seeker.profile.edit', compact('user'));
}

public function updateProfile(Request $request)
{
    $request->validate([
        'phone' => 'nullable|string|max:20',
        'skills' => 'nullable|string|max:1000',
        'about' => 'nullable|string|max:5000',
        'experience' => 'nullable|string|max:5000',
        'education' => 'nullable|string|max:5000',
        'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        'avatar' => 'nullable|image|max:2048',
    ]);

    $user = auth()->user();
    $user->phone = $request->phone;
    $user->skills = $request->skills;
    $user->about = $request->about;
    $user->experience = $request->experience;
    $user->education = $request->education;
    $user->linkedin = $request->linkedin;
    $user->github= $request->github;
    $user->portfolio= $request->portfolio;

    if ($request->hasFile('resume')) {
        if ($user->resume_path) {
            Storage::disk('public')->delete($user->resume_path);
        }

        $path = $request->file('resume')->store('resumes', 'public');
        $user->resume_path = $path;
    }

    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->avatar = $request->file('avatar')->store('avatars', 'public');
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully.');
}

public function publicProfile(User $user)
{
    abort_if($user->role !== 'seeker', 404);
    return view('seeker.profile.public', compact('user'));
}

public function downloadPDF(User $user)
{
    if ($user->role !== 'seeker') {
        abort(404);
    }

    $pdf = Pdf::loadView('seeker.profile.pdf', compact('user'));
    return $pdf->download($user->name . '-profile.pdf');
}

public function editResume()
{
    $user = auth()->user()->load('certificates');
    return view('seeker.resume.edit', compact('user'));
}

// public function updateResume(Request $request)
// {
//     $user = auth()->user();

//     $user->update([
//         'about'           => $request->about,
//         'education'       => $request->education,
//         'experience'      => $request->experience,
//         'skills'          => $request->skills,
//         'resume_template' => $request->resume_template ?? 'basic',
//     ]);

//     return back()->with('success', 'Resume updated!');
// }
public function updateResume(Request $request)
{
    $user = auth()->user();

    $user->update([
        'about' => $request->about,
        'education' => $request->education,
        'experience' => $request->experience,
        'skills' => $request->skills,
        'resume_template' => $request->resume_template ?? 'basic',
        'resume_visibility' => $request->has('resume_visibility'),
         'linkedin'        => $request->linkedin,
        'github'          => $request->github,
        'portfolio'       => $request->portfolio,
    ]);

    return back()->with('success', 'Resume updated!');
}


public function downloadResume()
{
    $user = auth()->user();
    $template = $user->resume_template ?? 'basic';

    $view = "seeker.resume.templates.resume_template_{$template}";

    // Fallback in case view doesn't exist
    if (!view()->exists($view)) {
        $view = "seeker.resume.templates.resume_template_basic";
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($view, compact('user'));
    return $pdf->download('resume.pdf');
}

public function storeCertificate(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $path = $request->file('certificate')->store('certificates', 'public');

    auth()->user()->certificates()->create([
        'title' => $request->title,
        'file_path' => $path,
    ]);

    return back()->with('success', 'Certificate uploaded successfully!');
}

public function destroy(Certificate $certificate)
{
    if ($certificate->seeker_id !== Auth::id()) {
        abort(403, 'Unauthorized access to this certificate.');
    }

    // Delete the file
    Storage::disk('public')->delete($certificate->file_path);

    // Delete DB record
    $certificate->delete();

    return back()->with('success', 'Certificate deleted.');
}

}
