
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Details - Student Complaint System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Complaint Details</h2>

        <a href="{{ route('complaints.index') }}" class="btn btn-secondary">
            Back to My Complaints
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Complaint Information
        </div>

        <div class="card-body">

            <div class="mb-3">
                <strong>Complaint ID:</strong>
                {{ $complaint->id }}
            </div>

            <div class="mb-3">
                <strong>Subject:</strong>
                {{ $complaint->subject }}
            </div>

            <div class="mb-3">
                <strong>Category:</strong>
                {{ $complaint->category }}
            </div>

            <div class="mb-3">
                <strong>Description:</strong>
                <p>{{ $complaint->description }}</p>
            </div>

            <div class="mb-3">
                <strong>Date Submitted:</strong>
                {{ $complaint->created_at->format('d M Y, h:i A') }}
            </div>

            <div class="mb-3">
                <strong>Current Status:</strong>

                <span class="badge bg-warning text-dark">
                    {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                </span>
            </div>

        <hr>

            <div class="mt-4">
                <h5>Administrator Response</h5>

                @if ($complaint->admin_response)
                    <div class="alert alert-info">
                        <p class="mb-2">{{ $complaint->admin_response }}</p>

                        <small class="text-muted">
                            Responded by:
                            {{ $complaint->responder?->name ?? 'Administrator' }}

                            @if ($complaint->responded_at)
                                | {{ $complaint->responded_at->format('d M Y, h:i A') }}
                            @endif
                        </small>
                    </div>
                @else
                    <p class="text-muted">
                        No response has been provided by the administrator yet.
                    </p>
                @endif
            </div>

        </div>
    </div>

</div>

</body>
</html>
