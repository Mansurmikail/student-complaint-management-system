
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | Complaint Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">

                        <h2 class="text-center mb-2">Student Registration</h2>

                        <p class="text-center text-muted mb-4">
                            Create an account to submit and track your complaints.
                        </p>

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

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control"
                                    value="{{ old('name') }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="matric_number" class="form-label">
                                    Matriculation Number
                                </label>
                                <input
                                    type="text"
                                    name="matric_number"
                                    id="matric_number"
                                    class="form-control"
                                    value="{{ old('matric_number') }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="faculty" class="form-label">Faculty</label>
                                <input
                                    type="text"
                                    name="faculty"
                                    id="faculty"
                                    class="form-control"
                                    value="{{ old('faculty') }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input
                                    type="text"
                                    name="department"
                                    id="department"
                                    class="form-control"
                                    value="{{ old('department') }}"
                                    required
                                >
                            </div>


                            <!-- Level Dropdown -->
                            <div class="mb-3">
                                <label for="level" class="form-label">Level</label>
                                <select name="level" id="level" class="form-select" required>
                                    <option value="">Select Your Level</option>
                                    <option value="ND I" @selected(old('level') == 'ND I')>ND I</option>
                                    <option value="ND II" @selected(old('level') == 'ND II')>ND II</option>
                                    <option value="HND I" @selected(old('level') == 'HND I')>HND I</option>
                                    <option value="HND II" @selected(old('level') == 'HND II')>HND II</option>
                                </select>
                            </div>

                            <!-- Trade Dropdown -->
                            <div class="mb-3">
                                <label for="trade" class="form-label">Trade</label>
                                <select name="trade" id="trade" class="form-select" required>
                                    <option value="">Select Your Trade</option>

                                    @php
                                        $trades = [
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
                                        ];
                                    @endphp

                                    @foreach ($trades as $trade)
                                        <option value="{{ $trade }}"
                                            @selected(old('trade') == $trade)>
                                            {{ $trade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input
                                    type="tel"
                                    name="phone"
                                    id="phone"
                                    class="form-control"
                                    value="{{ old('phone') }}"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">
                                    Confirm Password
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Create Student Account
                            </button>
                        </form>

                        <p class="text-center mt-4 mb-0">
                            Already registered?
                            <a href="{{ route('login') }}">Sign in</a>
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
