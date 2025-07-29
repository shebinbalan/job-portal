@extends('layouts.app')

@section('title', 'Apply to ' . $job->title)

@section('content')
<div class="card p-4 shadow-sm">
    <h4 class="mb-3">Apply to {{ $job->title }}</h4>

    <form method="POST" action="{{ route('seeker.applications.store', $job) }}" enctype="multipart/form-data">
        @csrf

        <!-- Resume Upload -->
        <div class="mb-3">
            <label class="form-label">Upload Resume (PDF/DOC)</label>
            <input type="file" name="resume" class="form-control" required>
            @error('resume') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <!-- 🔽 Cover Letter Template Dropdown -->
        <div class="mb-3">
            <label class="form-label">Select Cover Letter Template</label>
            <select id="templateSelect" class="form-select">
                <option value="">-- Choose Template --</option>
                @foreach(\App\Models\CoverLetterTemplate::where('user_id', auth()->id())->get() as $template)
                    <option value="{{ $template->id }}">{{ $template->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- ✍️ Cover Letter Text Area -->
        <div class="mb-3">
            <label class="form-label">Cover Letter (optional)</label>
            <textarea name="cover_letter" id="coverLetterArea" rows="5" class="form-control">{{ old('cover_letter') }}</textarea>
        </div>

        <!-- 📁 Optional File Upload -->
        <div class="mb-3">
            <label for="cover_letter_file" class="form-label">Or Upload Cover Letter</label>
            <input type="file" name="cover_letter_file" class="form-control">
        </div>

        <button class="btn btn-success">
            <i class="bi bi-send me-1"></i> Submit Application
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('templateSelect')?.addEventListener('change', function () {
    const id = this.value;
    if (id) {
        fetch(`/seeker/cover-letters/${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('coverLetterArea').value = data.content;
            });
    }
});
</script>
@endpush
