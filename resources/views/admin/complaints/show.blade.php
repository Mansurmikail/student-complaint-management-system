<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Complaint Details</h2>

        <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
            Back to Complaints
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Student Information
        </div>

        <div class="card-body">
            <p><strong>Name:</strong> {{ $complaint->user->name }}</p>
            <p><strong>Email:</strong> {{ $complaint->user->email }}</p>
            <p><strong>Matriculation Number:</strong> {{ $complaint->user->matric_number }}</p>
            <p><strong>Faculty:</strong> {{ $complaint->user->faculty }}</p>
            <p><strong>Department:</strong> {{ $complaint->user->department }}</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Complaint Information
        </div>

        <div class="card-body">
            <p><strong>Complaint ID:</strong> {{ $complaint->id }}</p>
            <p><strong>Subject:</strong> {{ $complaint->subject }}</p>
            <p><strong>Category:</strong> {{ $complaint->category }}</p>
            <p><strong>Date Submitted:</strong> {{ $complaint->created_at->format('d M Y, h:i A') }}</p>
            <p>
                <strong>Status:</strong>

                @php
                    $statusColors = [
                        'pending' => 'warning',
                        'under_review' => 'info',
                        'resolved' => 'success',
                        'rejected' => 'danger',
                    ];
                @endphp

                <span class="badge bg-{{ $statusColors[$complaint->status] ?? 'secondary' }}">
                    {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                </span>
            </p>
            <hr>

                <h5>Update Complaint Status</h5>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.complaints.updateStatus', $complaint->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Select New Status</label>

                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="under_review" {{ $complaint->status === 'under_review' ? 'selected' : '' }}>
                                Under Review
                            </option>

                            <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>
                                Resolved
                            </option>

                            <option value="rejected" {{ $complaint->status === 'rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>
                        </select>

                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update Status
                    </button>
                </form>

            <hr>

            <h5>Complaint Description</h5>
            <p class="mb-0">{{ $complaint->description }}</p>
            <hr>

<h5>Administrator Response</h5>

@if ($complaint->admin_response)
    <div class="alert alert-info">
        <strong>Previous Response:</strong>

        <p class="mb-1 mt-2">{{ $complaint->admin_response }}</p>

        <small class="text-muted">
            Responded by:
            {{ $complaint->responder?->name ?? 'Administrator' }}

            @if ($complaint->responded_at)
                | {{ $complaint->responded_at->format('d M Y, h:i A') }}
            @endif
        </small>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

            <form method="POST"
                action="{{ route('admin.complaints.storeResponse', $complaint->id) }}">

                @csrf

                <div class="mb-3">
                    <label for="admin_response" class="form-label">
                        Write Your Response
                    </label>

                    <textarea
                        name="admin_response"
                        id="admin_response"
                        class="form-control"
                        rows="5"
                        minlength="5"
                        maxlength="5000"
                        required
                    >{{ old('admin_response', $complaint->admin_response) }}</textarea>

                    @error('admin_response')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    Submit Response
                </button>
            </form>
        </div>
    </div>

</div>

</body>
</html>