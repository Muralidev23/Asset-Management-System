<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Asset;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $employeeCount = Employee::count();
        $assetCount = Asset::count();
        $assignedCount = Asset::where('status', 'assigned')->count();
        $availableCount = Asset::where('status', 'available')->count();

        // Retrieve and compile recent asset activities
        $assets = Asset::all();
        $allHistory = [];
        foreach ($assets as $asset) {
            $history = $asset->history ?? [];
            foreach ($history as $entry) {
                $entry['asset_name'] = $asset->name;
                $entry['asset_id_code'] = $asset->asset_id;
                $entry['asset_type'] = $asset->type;
                $allHistory[] = $entry;
            }
        }

        // Sort history by date descending
        usort($allHistory, function ($a, $b) {
            return strtotime($b['date'] ?? '') <=> strtotime($a['date'] ?? '');
        });

        // Get 5 most recent activities
        $recentActivities = array_slice($allHistory, 0, 5);

        return view('admin.dashboard', compact(
            'employeeCount', 
            'assetCount', 
            'assignedCount', 
            'availableCount', 
            'recentActivities'
        ));
    }
}
