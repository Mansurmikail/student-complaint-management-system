
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student Complaint Management System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">

                        <h2 class="text-center mb-2">Welcome Back</h2>

                        <p class="text-center text-muted mb-4">
                            Sign in to your complaint management account.
                        </p>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <div class="form-check mb-3">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    id="remember"
                                    class="form-check-input"
                                >

                                <label for="remember" class="form-check-label">
                                    Remember me
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Sign In
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        </div>

                        <p class="text-center mt-3 mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}">Register as a student</a>
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
