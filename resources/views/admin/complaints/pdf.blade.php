
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Complaint Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header h3 {
            font-size: 14px;
            margin-top: 12px;
        }

        .meta {
            margin-bottom: 15px;
        }

        .meta table {
            width: 100%;
            border: none;
        }

        .meta td {
            border: none;
            padding: 3px;
        }

        table.records {
            width: 100%;
            border-collapse: collapse;
        }

        .records th,
        .records td {
            border: 1px solid #555;
            padding: 6px;
            text-align: left;
        }

        .records th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #999;
            text-align: center;
            font-size: 9px;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>VSESC, The Polytechnic, Ibadan</h2>
        <p>Student Complaint Management System</p>
        <h3>STUDENT COMPLAINT REPORT</h3>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td>
                    <strong>Total Complaints:</strong>
                    {{ $complaints->count() }}
                </td>
                <td style="text-align: right;">
                    <strong>Report Generated:</strong>
                    {{ now()->format('d M Y, h:i A') }}
                </td>
            </tr>
        </table>
    </div>

    <table class="records">
        <thead>
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
                    <td colspan="8" style="text-align: center;">
                        No complaints found for the selected criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        VSESC, The Polytechnic, Ibadan<br>
        Official Student Complaint Report
    </div>

</body>
</html>
