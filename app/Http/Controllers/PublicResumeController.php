<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class PublicResumeController extends Controller
{
   public function show(User $user)
    {
        if ($user->role !== 'seeker' || !$user->resume_visibility) {
            abort(404);
        }

        $template = $user->resume_template ?? 'basic';

        return view("seeker.resume.templates.resume_template_{$template}", compact('user'));
    }
}
