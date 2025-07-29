<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Job;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $userTrend = User::selectRaw("DATE(created_at) as date, COUNT(*) as count")
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    $jobsPerCategory = Category::withCount('jobs')->get();

    $recentJobs = Job::with('company')->latest()->take(5)->get();

    $recentUsers = User::latest()->take(5)->get();

    return view('admin.dashboard', [
        'totalUsers' => User::count(),
        'employers' => User::where('role', 'employer')->count(),
        'seekers' => User::where('role', 'seeker')->count(),
        'jobs' => Job::count(),
        'userTrend' => $userTrend,
        'jobsPerCategory' => $jobsPerCategory,
        'recentJobs' => $recentJobs,
        'recentUsers' => $recentUsers,
    ]);
}
}
