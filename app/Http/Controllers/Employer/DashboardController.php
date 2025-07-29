<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\Bookmark;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $employerId = Auth::id();
        $jobIds = Job::where('user_id', $employerId)->pluck('id');

        $from = $request->input('from');
        $to = $request->input('to');
        $filterJobId = $request->input('job_id');

        $query = JobApplication::whereIn('job_id', $jobIds);
        if ($from) $query->whereDate('created_at', '>=', $from);
        if ($to) $query->whereDate('created_at', '<=', $to);
        if ($filterJobId) $query->where('job_id', $filterJobId);

        $totalApplications = $query->count();
        $bookmarkedCount = Bookmark::where('employer_id', $employerId)->count();

        $statusBreakdown = $query
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $applicationsPerJob = JobApplication::whereIn('job_id', $jobIds)
            ->selectRaw('job_id, COUNT(*) as count')
            ->groupBy('job_id')
            ->with('job')
            ->get();

        $applicationsByDate = $query
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $applicationsByDate->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('M d');
        });

        $chartData = $applicationsByDate->pluck('count');

        return view('employer.dashboard', compact(
            'totalApplications',
            'bookmarkedCount',
            'statusBreakdown',
            'applicationsPerJob',
            'applicationsByDate',
            'chartLabels',
            'chartData',
            'from',
            'to',
            'filterJobId'
        ));
    }
}
