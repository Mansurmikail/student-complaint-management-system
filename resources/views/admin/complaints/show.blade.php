
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .text-content {
            overflow-wrap: anywhere;
            white-space: pre-wrap;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 1rem;
            }
        }
    </style>
</head>

<body class="bg-light">

<div class="container py-4 py-md-5">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <h2 class="mb-0">Complaint Details</h2>

        <a href="{{ route('admin.complaints.index') }}" class="btn btn-secondary">
            Back to Complaints
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            Student Information
        </div>

        <div class="card-body">
            <p><strong>Name:</strong> {{ $complaint->user->name }}</p>

            <p class="text-break">
                <strong>Email:</strong> {{ $complaint->user->email }}
            </p>

            <p>
                <strong>Matriculation Number:</strong>
                {{ $complaint->user->matric_number }}
            </p>

            <p><strong>Faculty:</strong> {{ $complaint->user->faculty }}</p>

            <p><strong>Department:</strong> {{ $complaint->user->department }}</p>

            <p><strong>Level:</strong> {{ $complaint->user->level ?? 'Not provided' }}</p>

            <p><strong>Trade:</strong> {{ $complaint->user->trade ?? 'Not provided' }}</p>

            <p class="mb-0">
                <strong>Phone Number:</strong> {{ $complaint->user->phone ?? 'Not provided' }}
            </p>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Complaint Information
        </div>

        <div class="card-body">

            <p><strong>Complaint ID:</strong> {{ $complaint->id }}</p>

            <p class="text-content">
                <strong>Subject:</strong> {{ $complaint->subject }}
            </p>

            <p><strong>Category:</strong> {{ $complaint->category }}</p>

            <p>
                <strong>Date Submitted:</strong>
                {{ $complaint->created_at->format('d M Y, h:i A') }}
            </p>

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

                <div class="d-grid d-sm-flex">
                    <button type="submit" class="btn btn-primary">
                        Update Status
                    </button>
                </div>
            </form>

            <hr>

            <h5>Complaint Description</h5>

            <p class="mb-0 text-content">{{ $complaint->description }}</p>

            <hr>

            <h5>Administrator Response</h5>

            @if ($complaint->admin_response)
                <div class="alert alert-info">
                    <strong>Previous Response:</strong>

                    <p class="mb-1 mt-2 text-content">{{ $complaint->admin_response }}</p>

                    <small class="text-muted">
                        Responded by:
                        {{ $complaint->responder?->name ?? 'Administrator' }}

                        @if ($complaint->responded_at)
                            | {{ $complaint->responded_at->format('d M Y, h:i A') }}
                        @endif
                    </small>
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

                <div class="d-grid d-sm-flex">
                    <button type="submit" class="btn btn-success">
                        Submit Response
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

</body>
</html>
