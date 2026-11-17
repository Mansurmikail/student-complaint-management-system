<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Total complaints
        $totalComplaints = Complaint::count();

        // Complaint counts by status
        $statuses = [
            'pending',
            'under_review',
            'resolved',
            'rejected',
        ];

        $statusCounts = [];

        foreach ($statuses as $status) {
            $statusCounts[$status] = Complaint::where('status', $status)->count();
        }

        // Complaint counts by category
        $categories = [
            'Academic',
            'Registration',
            'Financial',
            'Results',
            'Facilities',
            'Other',
        ];

        $categoryCounts = [];

        foreach ($categories as $category) {
            $categoryCounts[$category] = Complaint::where('category', $category)->count();
        }

        // Monthly complaint trends for the last 12 months
        $monthlyLabels = [];
        $monthlyCounts = [];

        $startDate = Carbon::now()->startOfMonth()->subMonths(11);

        for ($i = 0; $i < 12; $i++) {
            $month = $startDate->copy()->addMonths($i);

            $monthlyLabels[] = $month->format('M Y');

            $monthlyCounts[] = Complaint::whereBetween('created_at', [
                $month->copy()->startOfMonth(),
                $month->copy()->endOfMonth(),
            ])->count();
        }

        return view('admin.dashboard', compact(
            'totalComplaints',
            'statusCounts',
            'categoryCounts',
            'monthlyLabels',
            'monthlyCounts'
        ));
    }
}
