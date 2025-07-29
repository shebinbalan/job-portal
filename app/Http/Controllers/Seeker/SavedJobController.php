<?php

namespace App\Http\Controllers\Seeker;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
   public function index(Request $request)
{
    $query = Auth::user()->savedJobs()->with('company');

    if ($request->filled('keyword')) {
        $query->where('title', 'like', '%' . $request->keyword . '%');
    }

    if ($request->filled('industry')) {
        $query->where('industry', $request->industry);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    $savedJobs = $query->get();

    return view('seeker.saved-jobs.index', compact('savedJobs'));
}

    public function toggle($jobId)
    {
        $user = Auth::user();
        $job = Job::find($jobId);

        if (! $job) {
            return response()->json(['error' => 'Job not found.'], 404);
        }

        if ($user->savedJobs()->where('job_id', $jobId)->exists()) {
            $user->savedJobs()->detach($jobId);
            return response()->json(['saved' => false]);
        } else {
            $user->savedJobs()->attach($jobId, [
                'filters' => json_encode([
                    'industry' => request('industry'),
                    'type' => request('type'),
                    'keyword' => request('keyword'),
                ])
            ]);
            return response()->json(['saved' => true]);
        }
    }


    
}