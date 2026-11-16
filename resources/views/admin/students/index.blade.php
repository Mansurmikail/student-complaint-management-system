<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students - Student Complaint System</title>

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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Manage Students</h3>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="GET" action="{{ route('admin.students.index') }}" class="mb-4">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by name, email or matric number"
                        value="{{ request('search') }}"
                    >

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
                        Clear
                    </a>
                </div>
            </form>

            <p class="text-muted">
                Total students found: {{ $students->total() }}
            </p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Matric Number</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Faculty</th>
                            <th>Phone</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $students->firstItem() + $loop->index }}</td>
                                <td>
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="text-decoration-none fw-semibold">
                                        {{ $student->name }}
                                    </a>
                                </td>
                                <td>{{ $student->matric_number ?? 'N/A' }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->department ?? 'N/A' }}</td>
                                <td>{{ $student->faculty ?? 'N/A' }}</td>
                                <td>{{ $student->phone ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No student accounts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $students->links('pagination::bootstrap-5') }}

        </div>
    </div>

</div>

</body>
</html>
