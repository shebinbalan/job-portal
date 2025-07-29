<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoverLetterTemplate;

class CoverLetterTemplateController extends Controller
{
    public function index()
    {
        $templates = CoverLetterTemplate::where('user_id', auth()->id())->get();
        return view('seeker.cover-letters.index', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        CoverLetterTemplate::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Template saved!');
    }

    public function destroy(CoverLetterTemplate $template)
    {
        if ($template->user_id !== auth()->id()) abort(403);
        $template->delete();
        return back()->with('success', 'Template deleted!');
    }

    public function show(CoverLetterTemplate $template)
    {
        if ($template->user_id !== auth()->id()) abort(403);
        return response()->json($template);
    }
}
