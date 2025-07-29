<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class BookmarkController extends Controller
{
    public function toggle(User $user)
    {
        $employer = auth()->user();

        if ($employer->bookmarkedSeekers()->where('seeker_id', $user->id)->exists()) {
            $employer->bookmarkedSeekers()->detach($user->id);
            return back()->with('success', 'Seeker removed from bookmarks.');
        }

        $employer->bookmarkedSeekers()->attach($user->id);
        return back()->with('success', 'Seeker bookmarked.');
    }

    public function index()
    {
        $employer = auth()->user();
        $bookmarks = $employer->bookmarkedSeekers()->get();

        return view('employer.bookmarks.index', compact('bookmarks'));
    }
}
