<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    /**
     * Show the employee dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            // If the user has an admin role, redirect them to the admin dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return abort(404, 'Employee profile not found.');
        }

        // Get currently assigned assets
        $assignedAssets = $employee->assets;

        // Compile history of assets that have been assigned or returned by this employee
        $allAssets = Asset::all();
        $myHistory = [];
        foreach ($allAssets as $asset) {
            $history = $asset->history ?? [];
            foreach ($history as $entry) {
                if (isset($entry['employee_id']) && $entry['employee_id'] == $employee->id) {
                    $entry['asset_name'] = $asset->name;
                    $entry['asset_id_code'] = $asset->asset_id;
                    $myHistory[] = $entry;
                }
            }
        }

        // Sort history by date descending
        usort($myHistory, function ($a, $b) {
            return strtotime($b['date'] ?? '') <=> strtotime($a['date'] ?? '');
        });

        return view('employee.dashboard', compact('employee', 'assignedAssets', 'myHistory'));
    }
}
