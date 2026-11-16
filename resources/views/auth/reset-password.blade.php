
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Student Complaint Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">

                        <h2 class="text-center mb-2">Reset Password</h2>

                        <p class="text-center text-muted mb-4">
                            Enter your new password below.
                        </p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ old('email', $request->email) }}"
                                    required
                                    readonly
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    required
                                    autofocus
                                    autocomplete="new-password"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Confirm New Password
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    required
                                    autocomplete="new-password"
                                >
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Reset Password
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}">Back to Login</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
