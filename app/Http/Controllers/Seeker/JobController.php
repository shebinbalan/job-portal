<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
  public function index(Request $request)
{
    $query = Job::with('company')
                ->where('is_active', true);

    if ($request->filled('keyword')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->keyword . '%')
              ->orWhere('description', 'like', '%' . $request->keyword . '%');
        });
    }

    if ($request->filled('location')) {
        $query->where('location', 'like', '%' . $request->location . '%');
    }

    if ($request->filled('industry')) {
        $query->where('industry', $request->industry);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('sort') && $request->sort === 'oldest') {
        $query->oldest();
    } else {
        $query->latest();
    }

    $jobs = $query->paginate(10)->appends($request->all());

    return view('seeker.jobs.index', compact('jobs'));
}


    public function show(Job $job)
    {
        $job->load('company', 'categories');

        return view('seeker.jobs.show', compact('job'));
    }
}
