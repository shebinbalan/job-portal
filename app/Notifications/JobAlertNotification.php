<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Job;

class JobAlertNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
     public $jobs;

    public function __construct($jobs)
    {
        $this->jobs = $jobs;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Job Matches for Your Alert')
            ->line('Here are new jobs matching your saved alert:')
            ->line('')
            ->line(
                collect($this->jobs)->map(function ($job) {
                    return "- [{$job->title}](" . route('seeker.jobs.show', $job->id) . ")";
                })->implode("\n")
            )
            ->line('')
            ->line('Login to view or apply now!');
    }
}
