<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobController extends Controller
{
     use AuthorizesRequests;
     
    public function index()
    {
        $jobs = Job::where('company_id', Auth::user()->company->id)
                   ->with('categories')
                   ->latest()
                   ->get();

        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $allCategories = Category::all();
        return view('employer.jobs.create', compact('allCategories'));
    }

 public function store(Request $request)
{
    $request->validate([
        'title'        => 'required|string|max:255',
        'description'  => 'required|string',
        'location'     => 'required|string|max:255',
        'type'         => 'required|in:full-time,part-time,internship,contract',
        'salary_min'   => 'nullable|integer',
        'salary_max'   => 'nullable|integer',
        'deadline'     => 'required|date',
        'categories'   => 'nullable|array',
        'categories.*' => 'exists:categories,id',
    ]);

    DB::transaction(function () use ($request) {
        // ✅ Step 1: Save the job first
        $job = new Job();
        $job->company_id  = Auth::user()->company->id;
        $job->title       = $request->title;
        $job->description = $request->description;
        $job->location    = $request->location;
        $job->type        = $request->type;
        $job->salary_min  = $request->salary_min;
        $job->salary_max  = $request->salary_max;
        $job->deadline    = $request->deadline;
        $job->is_active   = true;
        $job->save(); // 👈 Job MUST be saved before sync

        // ✅ Step 2: Attach categories only after the job has been saved
        if ($request->filled('categories')) {
            $job->categories()->sync($request->categories);
        }
    });

    return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully.');
}
    public function show(Job $job)
    {
        return view('employer.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        $allCategories = Category::all();
        return view('employer.jobs.edit', compact('job', 'allCategories'));
    }

   public function update(Request $request, Job $job)
{
    $request->validate([
        'title'        => 'required|string|max:255',
        'description'  => 'required|string',
        'location'     => 'required|string|max:255',
        'type'         => 'required|in:full-time,part-time,internship,contract',
        'salary_min'   => 'nullable|integer',
        'salary_max'   => 'nullable|integer',
        'deadline'     => 'required|date',
        'categories'   => 'nullable|array',
        'categories.*' => 'exists:categories,id',
    ]);

    DB::transaction(function () use ($request, $job) {
        // ✅ Update main job fields
        $job->update([
            'title'       => $request->title,
            'description' => $request->description,
            'location'    => $request->location,
            'type'        => $request->type,
            'salary_min'  => $request->salary_min,
            'salary_max'  => $request->salary_max,
            'deadline'    => $request->deadline,
            'is_active'   => $request->boolean('is_active'), // cleaner boolean
        ]);

        // ✅ Sync categories safely after job update
        if ($request->has('categories')) {
            $job->categories()->sync($request->categories);
        } else {
            $job->categories()->detach(); // Clear all if none selected
        }
    });

    return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully.');
}


    public function destroy(Job $job)
    {
        DB::transaction(function () use ($job) {
            $job->categories()->detach();
            $job->delete();
        });

        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted.');
    }

    public function duplicate(Job $job)
{
    $this->authorize('update', $job); // optional: ensure only the owner can duplicate

    $newJob = $job->replicate(); // clones attributes except id and timestamps
    $newJob->title = $job->title . ' (Copy)';
    $newJob->is_active = false; // optional: make duplicate inactive by default
    $newJob->deadline = now()->addDays(30); // reset deadline
    $newJob->push(); // saves the model

    return redirect()->route('employer.jobs.edit', $newJob->id)->with('success', 'Job duplicated successfully. You can now edit it.');
}

}
