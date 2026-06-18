<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Employee;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of assets.
     */
    public function index()
    {
        $assets = Asset::with('employee')->get();
        $employees = Employee::all(); // Used for assignment options
        return view('admin.assets.index', compact('assets', 'employees'));
    }

    /**
     * Show the form for creating a new asset.
     */
    public function create()
    {
        return view('admin.assets.create');
    }

    /**
     * Store a newly created asset.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|string|max:255|unique:assets,asset_id',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:assets,serial_number',
        ]);

        Asset::create([
            'asset_id' => $request->asset_id,
            'name' => $request->name,
            'type' => $request->type,
            'serial_number' => $request->serial_number,
            'status' => 'available',
            'assigned_to' => null,
            'history' => [],
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Show the form for editing the specified asset.
     */
    public function edit(Asset $asset)
    {
        return view('admin.assets.edit', compact('asset'));
    }

    /**
     * Update the specified asset in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'asset_id' => 'required|string|max:255|unique:assets,asset_id,' . $asset->id,
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:assets,serial_number,' . $asset->id,
        ]);

        $asset->update([
            'asset_id' => $request->asset_id,
            'name' => $request->name,
            'type' => $request->type,
            'serial_number' => $request->serial_number,
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
    }

    /**
     * Assign the asset to an employee.
     */
    public function assign(Request $request, Asset $asset)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        $history = $asset->history ?? [];
        $history[] = [
            'action' => 'assigned',
            'employee_id' => $employee->id,
            'employee_name' => $employee->name,
            'date' => now()->toDateTimeString(),
            'notes' => $request->notes ?? 'Asset assigned.',
        ];

        $asset->update([
            'status' => 'assigned',
            'assigned_to' => $employee->id,
            'history' => $history,
        ]);

        return redirect()->route('assets.index')->with('success', "Asset successfully assigned to {$employee->name}.");
    }

    /**
     * Return the asset back to the available pool.
     */
    public function returnAsset(Request $request, Asset $asset)
    {
        if ($asset->status !== 'assigned' || !$asset->assigned_to) {
            return redirect()->route('assets.index')->with('error', 'Asset is not currently assigned.');
        }

        $employee = Employee::find($asset->assigned_to);
        $empName = $employee ? $employee->name : 'Unknown';
        $empId = $employee ? $employee->id : null;

        $history = $asset->history ?? [];
        $history[] = [
            'action' => 'returned',
            'employee_id' => $empId,
            'employee_name' => $empName,
            'date' => now()->toDateTimeString(),
            'notes' => $request->notes ?? 'Asset returned to pool.',
        ];

        $asset->update([
            'status' => 'available',
            'assigned_to' => null,
            'history' => $history,
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset successfully returned.');
    }

    /**
     * Display the asset's history log.
     */
    public function history(Asset $asset)
    {
        return view('admin.assets.history', compact('asset'));
    }
}
