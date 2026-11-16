<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Complaint System</title>

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

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3>Welcome, {{ auth()->user()->name }}</h3>

                <p class="text-muted">
                    You are logged in as an administrator.
                </p>

                <hr>

                <h5>Administrator Dashboard</h5>

                <p>
                    This is where you will manage student complaints,
                    review submissions, respond to students and monitor
                    complaint statistics.
                </p>
                <hr>

                <h5>Student Account Management</h5>

                <p>
                    View student accounts and search by name, email or matriculation number.
                </p>

                <a href="{{ route('admin.students.index') }}" class="btn btn-primary">
                    Manage Students
                </a>
            </div>
        </div>
    </div>

</body>
</html>