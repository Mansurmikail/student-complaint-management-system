<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint | Student Complaint Management System</title>

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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5">

                        <h2 class="mb-2">Submit a Complaint</h2>

                        <p class="text-muted mb-4">
                            Provide the details of your complaint below.
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

                        <form method="POST" action="{{ route('complaints.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="subject" class="form-label">
                                    Complaint Subject
                                </label>

                                <input
                                    type="text"
                                    name="subject"
                                    id="subject"
                                    class="form-control"
                                    value="{{ old('subject') }}"
                                    placeholder="Enter the subject of your complaint"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">
                                    Complaint Category
                                </label>

                                <select name="category" id="category" class="form-select" required>
                                    <option value="">Select a category</option>
                                    <option value="Academic" {{ old('category') == 'Academic' ? 'selected' : '' }}>Academic</option>
                                    <option value="Registration" {{ old('category') == 'Registration' ? 'selected' : '' }}>Registration</option>
                                    <option value="Financial" {{ old('category') == 'Financial' ? 'selected' : '' }}>Financial</option>
                                    <option value="Results" {{ old('category') == 'Results' ? 'selected' : '' }}>Results</option>
                                    <option value="Facilities" {{ old('category') == 'Facilities' ? 'selected' : '' }}>Facilities</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    Complaint Description
                                </label>

                                <textarea
                                    name="description"
                                    id="description"
                                    class="form-control"
                                    rows="6"
                                    placeholder="Explain your complaint in detail..."
                                    required
                                >{{ old('description') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('home') }}" class="btn btn-secondary">
                                    Back to Dashboard
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    Submit Complaint
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
