<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company')->latest()->get();

        return view('admin.jobs.index', compact('jobs'));
    }
}
