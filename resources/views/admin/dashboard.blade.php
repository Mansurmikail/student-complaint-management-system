
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

    <div class="container mt-5 mb-5">

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3>Welcome, {{ auth()->user()->name }}</h3>

                <p class="text-muted mb-0">
                    You are logged in as an administrator.
                </p>
            </div>
        </div>

        <h4 class="mb-3">Administrator Dashboard</h4>

        <p class="text-muted">
            Monitor student complaints, review submissions, respond to students
            and analyse complaint statistics.
        </p>

        <!-- Total Complaints -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-primary h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Total Complaints</h6>
                        <h2 class="text-primary">{{ $totalComplaints }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-6 mb-3">
                <div class="card shadow-sm border-warning h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Pending</h6>
                        <h3 class="text-warning">{{ $statusCounts['pending'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-6 mb-3">
                <div class="card shadow-sm border-info h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Under Review</h6>
                        <h3 class="text-info">{{ $statusCounts['under_review'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-6 mb-3">
                <div class="card shadow-sm border-success h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Resolved</h6>
                        <h3 class="text-success">{{ $statusCounts['resolved'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-2 col-6 mb-3">
                <div class="card shadow-sm border-danger h-100">
                    <div class="card-body">
                        <h6 class="text-muted">Rejected</h6>
                        <h3 class="text-danger">{{ $statusCounts['rejected'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complaint Charts -->
        <div class="row mb-4">

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Complaints by Category</h5>
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Monthly Complaint Trends</h5>
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <!-- Management Links -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Complaint Management</h5>

                <p class="text-muted">
                    View submitted complaints, review them and respond to students.
                </p>

                <a href="{{ route('admin.complaints.index') }}" class="btn btn-primary mb-3">
                    Manage Complaints
                </a>

                <hr>

                <h5>Student Account Management</h5>

                <p class="text-muted">
                    View student accounts and search by name, email or matriculation number.
                </p>

                <a href="{{ route('admin.students.index') }}" class="btn btn-primary">
                    Manage Students
                </a>
            </div>
        </div>

    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Complaints by category
        const categoryLabels = @json(array_keys($categoryCounts));
        const categoryValues = @json(array_values($categoryCounts));

        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Number of Complaints',
                    data: categoryValues,
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#ffc107',
                        '#dc3545',
                        '#0dcaf0',
                        '#6f42c1'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Monthly complaint trends
        const monthlyLabels = @json($monthlyLabels);
        const monthlyValues = @json($monthlyCounts);

        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Complaints Received',
                    data: monthlyValues,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.15)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
