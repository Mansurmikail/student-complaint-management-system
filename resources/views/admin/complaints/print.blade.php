
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Complaint Report - VSESC</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
            color: #212529;
        }

        .report-container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 35px;
            background: #fff;
            border: 1px solid #ddd;
        }

        .report-header {
            text-align: center;
            border-bottom: 3px solid #212529;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .report-header h2 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .report-header h4 {
            margin-top: 15px;
        }

        .report-meta {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        table {
            font-size: 13px;
        }

        th {
            white-space: nowrap;
        }

        .report-footer {
            margin-top: 35px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 12px;
            color: #555;
        }

        @media print {
            body {
                background: #fff;
            }

            .report-container {
                max-width: 100%;
                margin: 0;
                padding: 0;
                border: none;
            }

            .no-print {
                display: none !important;
            }

            table {
                font-size: 11px;
            }

            thead {
                display: table-header-group;
            }

            tr {
                page-break-inside: avoid;
            }

            @page {
                size: landscape;
                margin: 15mm;
            }
        }
    </style>
</head>

<body>

<div class="report-container">

    <div class="d-flex justify-content-end mb-4 no-print gap-2">
        <a href="{{ route('admin.complaints.index') }}"
           class="btn btn-secondary">
            Back to Complaints
        </a>

        <button onclick="window.print()" class="btn btn-primary">
            Print Report
        </button>
    </div>

    <div class="report-header">
        <h2>VSESC, The Polytechnic, Ibadan</h2>
        <p class="mb-1">Student Complaint Management System</p>
        <h4>STUDENT COMPLAINT REPORT</h4>
    </div>

    <div class="report-meta">
        <div>
            <strong>Total Complaints:</strong>
            {{ $complaints->count() }}
        </div>

        <div>
            <strong>Report Generated:</strong>
            {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">

            <thead class="table-dark">
                <tr>
                    <th>S/N</th>
                    <th>Complaint ID</th>
                    <th>Student Name</th>
                    <th>Matric Number</th>
                    <th>Subject</th>
                    <th>Category</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($complaints as $complaint)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->user->name }}</td>
                        <td>{{ $complaint->user->matric_number ?? 'N/A' }}</td>
                        <td>{{ $complaint->subject }}</td>
                        <td>{{ $complaint->category }}</td>
                        <td>{{ $complaint->created_at->format('d M Y') }}</td>
                        <td>
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No complaints found for the selected criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="report-footer">
        <p class="mb-0">
            VSESC, The Polytechnic, Ibadan
        </p>
        <p class="mb-0">
            Official Student Complaint Report
        </p>
    </div>

</div>

</body>
</html>
