<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - Student Complaint Management System</title>
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
            <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit Student Information</h3>

        <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-secondary">
            Back to Profile
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Student Details
        </div>

        <div class="card-body">

            <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name"
                           class="form-control" value="{{ old('name', $student->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" id="email"
                           class="form-control" value="{{ old('email', $student->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="matric_number" class="form-label">Matric Number</label>
                    <input type="text" name="matric_number" id="matric_number"
                           class="form-control" value="{{ old('matric_number', $student->matric_number) }}">
                </div>

                <div class="mb-3">
                    <label for="faculty" class="form-label">Faculty</label>
                    <input type="text" name="faculty" id="faculty"
                           class="form-control" value="{{ old('faculty', $student->faculty) }}">
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" name="department" id="department"
                           class="form-control" value="{{ old('department', $student->department) }}">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" name="phone" id="phone"
                           class="form-control" value="{{ old('phone', $student->phone) }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>

                <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
