<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobAlert;
use App\Models\Job;
use App\Notifications\JobAlertNotification;

class SendJobAlerts extends Command
{
    protected $signature = 'alerts:send';
    protected $description = 'Send job alerts to subscribed users';

    public function handle()
    {
        $alerts = JobAlert::with('user')->get();

        foreach ($alerts as $alert) {
            $query = Job::query();

            if ($alert->keyword) {
                $query->where('title', 'like', "%{$alert->keyword}%");
            }
            if ($alert->location) {
                $query->where('location', 'like', "%{$alert->location}%");
            }
            if ($alert->industry) {
                $query->where('industry', $alert->industry);
            }
            if ($alert->type) {
                $query->where('type', $alert->type);
            }

            $jobs = $query->latest()->take(5)->get();

            if ($jobs->isNotEmpty()) {
                $alert->user->notify(new JobAlertNotification($jobs));
            }
        }

        $this->info('Job alerts sent.');
    }
}