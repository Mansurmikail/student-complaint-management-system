
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Complaints - Student Complaint System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <h2 class="mb-0">My Complaints</h2>

        <a href="{{ route('complaints.create') }}" class="btn btn-primary">
            Submit New Complaint
        </a>
    </div>

    @if ($complaints->isEmpty())
        <div class="alert alert-info">
            You have not submitted any complaints yet.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body p-2 p-md-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th>Category</th>
                                <th>Date Submitted</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->subject }}</td>
                                    <td>{{ $complaint->category }}</td>
                                    <td>{{ $complaint->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="{{ route('complaints.show', $complaint->id) }}"
                                           class="btn btn-sm btn-primary">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-3">
        <a href="{{ route('home') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>
    </div>

</div>

</body>
</html>
