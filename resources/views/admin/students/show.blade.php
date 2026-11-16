<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - Student Complaint System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            Student Complaint System - Admin
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light btn-sm">
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="container mt-5">

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if ($errors->has('password_reset'))
        <div class="alert alert-danger">
            {{ $errors->first('password_reset') }}
        </div>
        @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Student Profile</h3>

        <div>
            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary">
                Edit Student
            </a>
                <form method="POST" action="{{ route('admin.students.toggleStatus', $student->id) }}" class="d-inline">
                    @csrf
                    @method('PATCH')

                    @if ($student->is_active)
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to deactivate this student account?')">
                            Deactivate Account
                        </button>
                    @else
                        <button type="submit" class="btn btn-success"
                                onclick="return confirm('Are you sure you want to activate this student account?')">
                            Activate Account
                        </button>
                    @endif
                </form>


                <form method="POST"
                    action="{{ route('admin.students.passwordReset', $student->id) }}"
                    class="d-inline"
                    onsubmit="return confirm('Send a password reset link to this student?')">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        Send Password Reset Link
                    </button>
                </form>

            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                Back to Students
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            Student Information
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Full Name:</div>
                <div class="col-md-8">{{ $student->name }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Email Address:</div>
                <div class="col-md-8">{{ $student->email }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Matric Number:</div>
                <div class="col-md-8">{{ $student->matric_number ?? 'N/A' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Department:</div>
                <div class="col-md-8">{{ $student->department ?? 'N/A' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Faculty:</div>
                <div class="col-md-8">{{ $student->faculty ?? 'N/A' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Phone Number:</div>
                <div class="col-md-8">{{ $student->phone ?? 'N/A' }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Account Created:</div>
                <div class="col-md-8">{{ $student->created_at->format('d M Y, h:i A') }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Total Complaints:</div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Account Status:</div>
                    <div class="col-md-8">
                        @if ($student->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Deactivated</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <span class="badge bg-primary">{{ $student->complaints_count }}</span>
                </div>
            </div>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Student Complaint History
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Subject</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($complaints as $complaint)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $complaint->subject }}</td>
                                <td>{{ $complaint->category }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $complaint->status)) }}</td>
                                <td>{{ $complaint->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.complaints.show', $complaint->id) }}"
                                       class="btn btn-sm btn-primary">
                                        View Complaint
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    This student has not submitted any complaints.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

</body>
</html>
