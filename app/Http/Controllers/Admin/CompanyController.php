<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
     public function index()
    {
        $companies = Company::with('employer')->latest()->get();

        return view('admin.companies.index', compact('companies'));
    }
}
