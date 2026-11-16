<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /**
     * Display all complaints submitted by the logged-in student.
     */
    public function index(Request $request)
    {
        $complaints = $request->user()
            ->complaints()
            ->latest()
            ->get();

        return view('student.complaints.index', compact('complaints'));
    }


    /**
         * Display details of a student's individual complaint.
         */
        public function show(Request $request, $id)
        {
            $complaint = $request->user()->complaints()
                ->with('responder')
                ->findOrFail($id);

            return view('student.complaints.show', compact('complaint'));
        }

    /**
     * Display the complaint submission form.
     */
    public function create()
    {
        return view('student.complaints.create');
    }

    /**
     * Store a newly submitted complaint.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'in:Academic,Registration,Financial,Results,Facilities,Other'],
            'description' => ['required', 'string', 'min:10'],
        ]);

        $request->user()->complaints()->create($validated);

        return redirect()
            ->route('home')
            ->with('success', 'Your complaint has been submitted successfully.');
    }
}
