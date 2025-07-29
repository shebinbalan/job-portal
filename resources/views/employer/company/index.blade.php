@extends('employer-layout.app')

@section('title', 'Company Profile')

@section('header', 'Company Profile')

@section('content')
    <div class="row">
        <div class="col-md-8 col-lg-6">

            @if ($company)
                <!-- ✅ Company Profile Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            @if ($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" class="img-thumbnail me-3" style="height: 80px;" alt="Company Logo">
                            @else
                                <div class="bg-secondary text-white text-center d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px;">
                                    <span class="fw-bold">{{ strtoupper(substr($company->name, 0, 1)) }}</span>
                                </div>
                            @endif

                            <div>
                                <h5 class="card-title mb-1">{{ $company->name }}</h5>
                                <p class="mb-0">
                                    <strong>Website:</strong>
                                    <a href="{{ $company->website }}" target="_blank" class="text-decoration-underline text-primary">
                                        {{ $company->website }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <p class="mt-3">{{ $company->description }}</p>
<p><strong>Industry:</strong> {{ $company->industry }}</p>
<p><strong>Founded:</strong> {{ $company->founded_year }}</p>
<p><strong>Location:</strong> {{ $company->location }}</p>
<p><strong>Contact Email:</strong> {{ $company->contact_email }}</p>
<p><strong>Phone:</strong> {{ $company->phone }}</p>
<p><strong>LinkedIn:</strong> 
    <a href="{{ $company->linkedin }}" target="_blank">{{ $company->linkedin }}</a>
</p>
<p><strong>Size:</strong> {{ $company->size }}</p>
<p>
    <strong>Status:</strong>
    @if ($company->verified)
        <span class="badge bg-success">Verified</span>
    @else
        <span class="badge bg-secondary">Not Verified</span>
    @endif
</p>
                        <div class="mt-4">
                            <a href="{{ route('employer.company.edit') }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil me-1"></i> Edit Company Profile
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- 🚀 Create Company Button -->
                <div class="card shadow-sm border-0 text-center p-4">
                    <p class="mb-3">You haven’t created a company profile yet.</p>
                    <a href="{{ route('employer.company.create') }}" class="btn btn-success">
                        <i class="bi bi-building-add me-1"></i> Create Company Profile
                    </a>
                </div>
            @endif

        </div>
    </div>
@endsection
