
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Complaints - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">Student Complaint System - Admin</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container py-4">

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h3>All Student Complaints</h3>
                <p class="text-muted mb-0">
                    Review, filter and manage complaints submitted by students.
                </p>
            </div>

            <div class="d-grid gap-2 d-sm-flex flex-wrap">
                <a href="{{ route('admin.complaints.print', request()->query()) }}"
                   target="_blank"
                   class="btn btn-success">
                    Print Report
                </a>

                <a href="{{ route('admin.complaints.exportPdf', request()->query()) }}"
                   class="btn btn-danger">
                    Download PDF
                </a>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Complaint Filters -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <h5 class="mb-3">Filter Complaints</h5>

                <form method="GET" action="{{ route('admin.complaints.index') }}">

                    <div class="row g-3">

                        <div class="col-12 col-md-6">
                            <label for="student" class="form-label">Student</label>
                            <input
                                type="text"
                                name="student"
                                id="student"
                                class="form-control"
                                placeholder="Name, email or matric number"
                                value="{{ request('student') }}"
                            >
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach (['Academic', 'Registration', 'Financial', 'Results', 'Facilities', 'Other'] as $category)
                                    <option value="{{ $category }}" @selected(request('category') === $category)>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All Statuses</option>
                                @foreach ([
                                    'pending' => 'Pending',
                                    'under_review' => 'Under Review',
                                    'resolved' => 'Resolved',
                                    'rejected' => 'Rejected',
                                ] as $value => $label)
                                    <option value="{{ $value }}" @selected(request('status') === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="date_from" class="form-label">Date From</label>
                            <input
                                type="date"
                                name="date_from"
                                id="date_from"
                                class="form-control"
                                value="{{ request('date_from') }}"
                            >
                        </div>

                        <div class="col-12 col-md-3">
                            <label for="date_to" class="form-label">Date To</label>
                            <input
                                type="date"
                                name="date_to"
                                id="date_to"
                                class="form-control"
                                value="{{ request('date_to') }}"
                            >
                        </div>

                        <div class="col-12 col-md-6 d-grid d-sm-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                Apply Filters
                            </button>

                            <a href="{{ route('admin.complaints.index') }}"
                               class="btn btn-outline-secondary">
                                Clear Filters
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        <!-- Complaint Records -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
                <h5 class="mb-0">Complaint Records</h5>

                <span class="text-muted">
                    {{ $complaints->total() }} complaint(s) found
                </span>
            </div>

            @if ($complaints->count() > 0)

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Matric Number</th>
                                <th>Department</th>
                                <th>Level</th>
                                <th>Trade</th>
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
                                    <td>{{ $complaint->id }}</td>

                                    <td>{{ $complaint->user->name }}</td>

                                    <td>{{ $complaint->user->matric_number }}</td>

                                    <td>{{ $complaint->user->department }}</td>

                                    <td>{{ $complaint->user->level ?? 'Not provided' }}</td>

                                    <td>{{ $complaint->user->trade ?? 'Not provided' }}</td>

                                    <td>{{ $complaint->subject }}</td>

                                    <td>{{ $complaint->category }}</td>

                                    <td>{{ $complaint->created_at->format('d M Y') }}</td>

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
                                        <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                                        class="btn btn-primary btn-sm">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="mt-3">
                    {{ $complaints->links() }}
                </div>

            @else

                <div class="alert alert-info mb-0">
                    No complaints match your search criteria.
                </div>

            @endif

        </div>
    </div>


</body>
</html>
