
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | Complaint Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Student Complaint System</a>

            <div class="d-flex align-items-center">
                <span class="text-white me-3">
                    Welcome, {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <div class="mb-4">
            <h2>Student Dashboard</h2>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <p class="text-muted">
                Welcome to your complaint management portal.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Submit a Complaint</h5>
                        <p class="card-text text-muted">
                            Submit a new complaint to the appropriate administrator.
                        </p>
                        <a href="{{ route('complaints.create') }}" class="btn btn-primary">
                        Submit a Complaint
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">My Complaints</h5>
                        <p class="card-text text-muted">
                            View and track the progress of your submitted complaints.
                        </p>
                        <a href="{{ route('complaints.index') }}" class="btn btn-primary">
                            View My Complaints
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">My Profile</h5>
                        <p class="card-text text-muted">
                            View your registered student information.
                        </p>
                        <button class="btn btn-primary" disabled>
                            Coming Soon
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
