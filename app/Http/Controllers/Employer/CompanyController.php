<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

    public function index()
{
    $company = Auth::user()->company;

    if (!$company) {
        return redirect()->route('employer.company.create')->with('info', 'No company profile found. Please create one.');
    }

    return view('employer.company.index', compact('company'));
}
    // Show the create form
    public function create()
    {
        // Only one company per employer
        if (Auth::user()->company) {
            return redirect()->route('employer.company.edit')->with('info', 'You already created a company profile.');
        }

        return view('employer.company.create');
    }

    // Store the company
    public function store(Request $request)
    {
       $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'location' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url',
            'size' => 'nullable|string|max:50',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Company::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'website' => $request->website,
        'logo' => $logoPath,
        'description' => $request->description,
        'industry' => $request->industry,
        'founded_year' => $request->founded_year,
        'location' => $request->location,
        'contact_email' => $request->contact_email,
        'phone' => $request->phone,
        'linkedin' => $request->linkedin,
        'size' => $request->size,
        ]);

        return redirect()->route('employer.company.index')->with('success', 'Company profile created!');
    }

    // Show the edit form
    public function edit()
    {
        $company = Auth::user()->company;

        if (!$company) {
            return redirect()->route('employer.company.create');
        }

        return view('employer.company.edit', compact('company'));
    }

    // Update the company
    public function update(Request $request)
    {
        $company = Auth::user()->company;

                $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'location' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'linkedin' => 'nullable|url',
            'size' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo && Storage::disk('public')->exists($company->logo)) {
                Storage::disk('public')->delete($company->logo);
            }

            $company->logo = $request->file('logo')->store('logos', 'public');
        }

        $company->update([
            'name' => $request->name,
            'website' => $request->website,
            'description' => $request->description,
            'industry' => $request->industry,
            'founded_year' => $request->founded_year,
            'location' => $request->location,
            'contact_email' => $request->contact_email,
            'phone' => $request->phone,
            'linkedin' => $request->linkedin,
            'size' => $request->size,
        ]);

        $company->save();

        return redirect()->route('employer.company.index')->with('success', 'Company profile updated.');
    }
}

