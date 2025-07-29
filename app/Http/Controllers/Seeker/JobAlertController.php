<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobAlert;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class JobAlertController extends Controller
{

    use AuthorizesRequests;

    public function index()
{
    $alerts = JobAlert::where('user_id', auth()->id())->latest()->get();
    return view('seeker.alerts.index', compact('alerts'));
}


    public function store(Request $request)
    {
        JobAlert::updateOrCreate([
            'user_id' => auth()->id(),
            'keyword' => $request->keyword,
            'location' => $request->location,
            'industry' => $request->industry,
            'type' => $request->type,
        ]);

        return back()->with('success', 'Job Alert created!');
    }


    public function destroy($id)
{
    $alert = JobAlert::where('user_id', auth()->id())->findOrFail($id);
    $alert->delete();

    return back()->with('success', 'Job alert deleted.');
}

public function toggle(JobAlert $alert)
{
    // Ensure the alert belongs to the current user
    if ($alert->user_id !== auth()->id()) {
        abort(403);
    }

    // Toggle the enabled status
    $alert->enabled = !$alert->enabled;
    $alert->save();

    return back()->with('success', 'Alert ' . ($alert->enabled ? 'enabled' : 'disabled') . '.');
}
}
