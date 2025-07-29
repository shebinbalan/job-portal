@extends('employer-layout.app')

@section('title', 'Create Company Profile')

@section('header', 'Create Company Profile')

@section('content')
    <form method="POST" action="{{ route('employer.company.store') }}" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf

        <!-- Company Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Company Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            <x-input-error :messages="$errors->get('name')" class="text-danger" />
        </div>

        <!-- Website -->
        <div class="mb-3">
            <label for="website" class="form-label">Website</label>
            <input type="url" name="website" value="{{ old('website') }}" class="form-control">
            <x-input-error :messages="$errors->get('website')" class="text-danger" />
        </div>

        <!-- Logo -->
        <div class="mb-3">
            <label for="logo" class="form-label">Company Logo</label>
            <input type="file" name="logo" class="form-control">
            <x-input-error :messages="$errors->get('logo')" class="text-danger" />
        </div>

        <!-- Industry -->
        <div class="mb-3">
            <label for="industry" class="form-label">Industry</label>
            <input type="text" name="industry" value="{{ old('industry') }}" class="form-control">
            <x-input-error :messages="$errors->get('industry')" class="text-danger" />
        </div>

        <!-- Founded Year -->
        <div class="mb-3">
            <label for="founded_year" class="form-label">Founded Year</label>
            <input type="number" name="founded_year" value="{{ old('founded_year') }}" class="form-control">
            <x-input-error :messages="$errors->get('founded_year')" class="text-danger" />
        </div>

        <!-- Location -->
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" value="{{ old('location') }}" class="form-control">
            <x-input-error :messages="$errors->get('location')" class="text-danger" />
        </div>

        <!-- Contact Email -->
        <div class="mb-3">
            <label for="contact_email" class="form-label">Contact Email</label>
            <input type="email" name="contact_email" value="{{ old('contact_email') }}" class="form-control">
            <x-input-error :messages="$errors->get('contact_email')" class="text-danger" />
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            <x-input-error :messages="$errors->get('phone')" class="text-danger" />
        </div>

        <!-- LinkedIn -->
        <div class="mb-3">
            <label for="linkedin" class="form-label">LinkedIn</label>
            <input type="url" name="linkedin" value="{{ old('linkedin') }}" class="form-control">
            <x-input-error :messages="$errors->get('linkedin')" class="text-danger" />
        </div>

        <!-- Company Size -->
        <div class="mb-3">
            <label for="size" class="form-label">Company Size</label>
            <input type="text" name="size" value="{{ old('size') }}" class="form-control" placeholder="e.g. 1-10, 11-50, 100+">
            <x-input-error :messages="$errors->get('size')" class="text-danger" />
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="text-danger" />
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-building-add me-1"></i> Save Company
        </button>
    </form>
@endsection
