<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Notifications\ComplaintResponseNotification;
use App\Notifications\ComplaintStatusNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class ComplaintController extends Controller
{
    
/**
 * Display, filter and paginate student complaints.
 */
        public function index(Request $request)
        {
            $validated = $request->validate([
                'student' => ['nullable', 'string', 'max:255'],
                'category' => [
                    'nullable',
                    Rule::in([
                        'Academic',
                        'Registration',
                        'Financial',
                        'Results',
                        'Facilities',
                        'Other',
                    ]),
                ],
                'status' => [
                    'nullable',
                    Rule::in([
                        'pending',
                        'under_review',
                        'resolved',
                        'rejected',
                    ]),
                ],
                'date_from' => ['nullable', 'date'],
                'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            ]);

            $query = Complaint::with('user');

            if (!empty($validated['student'])) {
                $search = $validated['student'];

                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('matric_number', 'like', "%{$search}%");
                });
            }

            if (!empty($validated['category'])) {
                $query->where('category', $validated['category']);
            }

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }

            if (!empty($validated['date_from'])) {
                $query->whereDate('created_at', '>=', $validated['date_from']);
            }

            if (!empty($validated['date_to'])) {
                $query->whereDate('created_at', '<=', $validated['date_to']);
            }

            $complaints = $query->latest()
                ->paginate(15)
                ->withQueryString();

            return view('admin.complaints.index', compact('complaints'));
        }


        /**
         * Generate a printable report of filtered complaints.
         */
        public function printReport(Request $request)
        {
            $validated = $request->validate([
                'student' => ['nullable', 'string', 'max:255'],
                'category' => [
                    'nullable',
                    Rule::in([
                        'Academic',
                        'Registration',
                        'Financial',
                        'Results',
                        'Facilities',
                        'Other',
                    ]),
                ],
                'status' => [
                    'nullable',
                    Rule::in([
                        'pending',
                        'under_review',
                        'resolved',
                        'rejected',
                    ]),
                ],
                'date_from' => ['nullable', 'date'],
                'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            ]);

            $query = Complaint::with('user');

            if (!empty($validated['student'])) {
                $search = $validated['student'];

                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('matric_number', 'like', "%{$search}%");
                });
            }

            if (!empty($validated['category'])) {
                $query->where('category', $validated['category']);
            }

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }

            if (!empty($validated['date_from'])) {
                $query->whereDate('created_at', '>=', $validated['date_from']);
            }

            if (!empty($validated['date_to'])) {
                $query->whereDate('created_at', '<=', $validated['date_to']);
            }

            $complaints = $query->latest()->get();

            return view('admin.complaints.print', compact('complaints'));
        }


        /**
         * Export filtered complaints as a PDF report.
         */
        public function exportPdf(Request $request)
        {
            $validated = $request->validate([
                'student' => ['nullable', 'string', 'max:255'],
                'category' => [
                    'nullable',
                    Rule::in([
                        'Academic',
                        'Registration',
                        'Financial',
                        'Results',
                        'Facilities',
                        'Other',
                    ]),
                ],
                'status' => [
                    'nullable',
                    Rule::in([
                        'pending',
                        'under_review',
                        'resolved',
                        'rejected',
                    ]),
                ],
                'date_from' => ['nullable', 'date'],
                'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            ]);

            $query = Complaint::with('user');

            if (!empty($validated['student'])) {
                $search = $validated['student'];

                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('matric_number', 'like', "%{$search}%");
                });
            }

            if (!empty($validated['category'])) {
                $query->where('category', $validated['category']);
            }

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }

            if (!empty($validated['date_from'])) {
                $query->whereDate('created_at', '>=', $validated['date_from']);
            }

            if (!empty($validated['date_to'])) {
                $query->whereDate('created_at', '<=', $validated['date_to']);
            }

            $complaints = $query->latest()->get();

            $pdf = Pdf::loadView('admin.complaints.pdf', compact('complaints'))
                ->setPaper('a4', 'landscape');

            return $pdf->download('student-complaint-report.pdf');
        }



    /**
     * Display the full details of an individual complaint.
     */
    public function show($id)
    {
        $complaint = Complaint::with(['user', 'responder'])
            ->findOrFail($id);

        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Update the status of a complaint.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['pending', 'under_review', 'resolved', 'rejected']),
            ],
        ]);

        $complaint = Complaint::findOrFail($id);

        $previousStatus = $complaint->status;

        $complaint->update([
            'status' => $validated['status'],
        ]);

        if ($previousStatus !== $complaint->status) {
            $complaint->user->notify(
                new ComplaintStatusNotification($complaint, $previousStatus)
            );
        }

        return redirect()
            ->route('admin.complaints.show', $complaint->id)
            ->with('success', 'Complaint status updated successfully.');
    }

    /**
     * Submit an administrator response to a complaint.
     */
    public function storeResponse(Request $request, $id)
    {
        $validated = $request->validate([
            'admin_response' => [
                'required',
                'string',
                'min:5',
                'max:5000',
            ],
        ]);

        $complaint = Complaint::findOrFail($id);

        $complaint->update([
            'admin_response' => $validated['admin_response'],
            'responded_by' => $request->user()->id,
            'responded_at' => now(),
        ]);

        $complaint->user->notify(
            new ComplaintResponseNotification($complaint)
        );

        return redirect()
            ->route('admin.complaints.show', $complaint->id)
            ->with('success', 'Your response has been submitted successfully.');
    }
}