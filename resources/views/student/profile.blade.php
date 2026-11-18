<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Student Complaint Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Student Complaint System
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="container py-4 py-md-5">

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-3 p-md-4">

                        <h3 class="mb-2">My Student Profile</h3>

                        <p class="text-muted">
                            View and update your registered personal information.
                        </p>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

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

                        <form method="POST" action="{{ route('student.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control"
                                    value="{{ old('name', $student->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email"
                                    class="form-control"
                                    value="{{ old('email', $student->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="matric_number" class="form-label">
                                    Matriculation Number
                                </label>
                                <input type="text" id="matric_number"
                                    class="form-control"
                                    value="{{ $student->matric_number }}" readonly>

                                <small class="text-muted">
                                    Your matriculation number cannot be changed here.
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="faculty" class="form-label">Faculty</label>
                                <input type="text" name="faculty" id="faculty"
                                    class="form-control"
                                    value="{{ old('faculty', $student->faculty) }}">
                            </div>

                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" name="department" id="department"
                                    class="form-control"
                                    value="{{ old('department', $student->department) }}">
                            </div>

                            <div class="mb-3">
                                <label for="level" class="form-label">Level</label>
                                <select name="level" id="level" class="form-select" required>
                                    <option value="">Select Level</option>

                                    @foreach (['ND I', 'ND II', 'HND I', 'HND II'] as $level)
                                        <option value="{{ $level }}"
                                            @selected(old('level', $student->level) == $level)>
                                            {{ $level }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="trade" class="form-label">Trade</label>
                                <select name="trade" id="trade" class="form-select" required>
                                    <option value="">Select Trade</option>

                                    @foreach ([
                                        'Barbering',
                                        'Beading Works',
                                        'Brick/Block Moulding And Concreting',
                                        'Catering and Confectioneries',
                                        'Cosmetology',
                                        'Electrical Installation',
                                        'Fisheries',
                                        'Garment Making',
                                        'GSM Repairs and Servicing',
                                        'Household Products',
                                        'Leather Works',
                                        'Modern Car Repairs and Servicing',
                                        'Pure Water Production and Marketing',
                                        'Renewable Energy and Solar Inverter Energy',
                                        'Textile Technology',
                                        'Website Design and Software Development',
                                    ] as $trade)
                                        <option value="{{ $trade }}"
                                            @selected(old('trade', $student->trade) == $trade)>
                                            {{ $trade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="form-control"
                                    value="{{ old('phone', $student->phone) }}">
                            </div>

                            <div class="d-grid gap-2 d-sm-flex">
                                <button type="submit" class="btn btn-primary">
                                    Update Profile
                                </button>

                                <a href="{{ route('home') }}" class="btn btn-secondary">
                                    Back to Dashboard
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
