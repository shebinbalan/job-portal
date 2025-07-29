<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $categoryId = $request->get('category');
        $location = $request->get('location');

        // Recommended Jobs (infinite scroll: only first 10 shown initially)
        $recommendedQuery = Job::with('company', 'category')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($location, fn($q) => $q->where('location', 'ILIKE', "%$location%"))
            ->whereDoesntHave('applications', fn($q) => $q->where('user_id', $user->id))
            ->latest();

        $recommendedJobs = $recommendedQuery->take(10)->get();

        // Saved jobs
        $savedJobs = $user->savedJobs()->with('company', 'category')->latest()->get();

        // Applied jobs
        $appliedJobIds = JobApplication::where('user_id', $user->id)->pluck('job_id');
        $appliedJobs = Job::with('company')->whereIn('id', $appliedJobIds)->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('seeker.dashboard', compact(
            'recommendedJobs', 'savedJobs', 'appliedJobs', 'categories'
        ));
    }

    public function loadMore(Request $request)
    {
        $user = Auth::user();

        $categoryId = $request->get('category');
        $location = $request->get('location');

        $recommendedJobs = Job::with('company', 'category')
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->when($location, fn($q) => $q->where('location', 'ILIKE', "%$location%"))
            ->whereDoesntHave('applications', fn($q) => $q->where('user_id', $user->id))
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return view('partials.job-cards', ['jobs' => $recommendedJobs])->render();
        }

        return abort(404);
    }

//  public function preview($id)
// {
//     $job = Job::with('company', 'category')->findOrFail($id);
//     return view('seeker.job-preview', compact('job'));
// }
public function preview($id)
{
    $job = Job::with('company')->findOrFail($id);

    return view('seeker.partials.job-preview', compact('job'));
}

   public function toggleSave(Job $job)
{
    $user = auth()->user();

    if ($user->savedJobs()->where('job_id', $job->id)->exists()) {
        $user->savedJobs()->detach($job->id);
        return response()->json(['saved' => false]);
    } else {
        $user->savedJobs()->attach($job->id);
        return response()->json(['saved' => true]);
    }
}
}
