<h4>{{ $job->title }}</h4>
<p><strong>Company:</strong> {{ $job->company->name }}</p>
<p><strong>Location:</strong> {{ $job->location }}</p>
<p><strong>Type:</strong> <span class="badge bg-info">{{ ucfirst($job->type) }}</span></p>
<p><strong>Category:</strong> {{ $job->category->name ?? 'Uncategorized' }}</p>

<hr>
<div>{!! nl2br(e($job->description)) !!}</div>
