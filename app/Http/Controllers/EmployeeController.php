<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = Employee::with('user')->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|string|max:255|unique:employees,emp_id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'emp_role' => 'required|string|max:255',
            'doj' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'employee',
            ]);

            Employee::create([
                'user_id' => $user->id,
                'emp_id' => $request->emp_id,
                'name' => $request->name,
                'department' => $request->department,
                'designation' => $request->designation,
                'emp_role' => $request->emp_role,
                'doj' => $request->doj,
            ]);
        });

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        $employee->load('user', 'assets');
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $employee->load('user');
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'emp_id' => 'required|string|max:255|unique:employees,emp_id,' . $employee->id,
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->user_id,
            'password' => 'nullable|string|min:8',
            'department' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'emp_role' => 'required|string|max:255',
            'doj' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $employee) {
            $user = $employee->user;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $employee->update([
                'emp_id' => $request->emp_id,
                'name' => $request->name,
                'department' => $request->department,
                'designation' => $request->designation,
                'emp_role' => $request->emp_role,
                'doj' => $request->doj,
            ]);
        });

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            // Unassign assets and record in asset history
            $assets = Asset::where('assigned_to', $employee->id)->get();
            foreach ($assets as $asset) {
                $history = $asset->history ?? [];
                $history[] = [
                    'action' => 'returned',
                    'employee_id' => $employee->id,
                    'employee_name' => $employee->name,
                    'date' => now()->toDateTimeString(),
                    'notes' => 'Unassigned due to employee deletion.',
                ];
                $asset->update([
                    'status' => 'available',
                    'assigned_to' => null,
                    'history' => $history,
                ]);
            }

            // Delete user first (which cascades to employee)
            if ($employee->user) {
                $employee->user->delete();
            } else {
                $employee->delete();
            }
        });

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    /**
     * Show bulk upload form.
     */
    public function showUploadForm()
    {
        return view('admin.employees.upload');
    }

    /**
     * Handle bulk upload CSV.
     */
    public function handleUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            return redirect()->back()->with('error', 'Cannot open uploaded CSV file.');
        }

        // Get header
        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return redirect()->back()->with('error', 'CSV file is empty.');
        }

        // Trim headers to avoid spacing issues
        $header = array_map('trim', $header);

        // Required headers mapping
        $expectedHeaders = ['emp_id', 'name', 'email', 'department', 'designation', 'emp_role', 'doj', 'password'];
        foreach ($expectedHeaders as $expected) {
            if (!in_array($expected, $header)) {
                fclose($handle);
                return redirect()->back()->with('error', "Missing required column in CSV header: '{$expected}'");
            }
        }

        $importedCount = 0;
        $rowNumber = 1;
        $errors = [];

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;
                
                // Combine header with row values
                if (count($header) !== count($row)) {
                    // Pad or truncate row to match header count if there are missing/extra columns
                    $row = array_slice(array_pad($row, count($header), ''), 0, count($header));
                }

                $data = array_combine($header, $row);
                $data = array_map('trim', $data);

                // Run Validator manually for this row
                $validator = Validator::make($data, [
                    'emp_id' => 'required|string|max:255|unique:employees,emp_id',
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users,email',
                    'department' => 'required|string|max:255',
                    'designation' => 'required|string|max:255',
                    'emp_role' => 'required|string|max:255',
                    'doj' => 'required|date',
                    'password' => 'required|string|min:8',
                ]);

                if ($validator->fails()) {
                    $rowErrors = implode(', ', $validator->errors()->all());
                    $errors[] = "Row {$rowNumber} Error: {$rowErrors}";
                    continue;
                }

                // Create User
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => 'employee',
                ]);

                // Create Employee
                Employee::create([
                    'user_id' => $user->id,
                    'emp_id' => $data['emp_id'],
                    'name' => $data['name'],
                    'department' => $data['department'],
                    'designation' => $data['designation'],
                    'emp_role' => $data['emp_role'],
                    'doj' => $data['doj'],
                ]);

                $importedCount++;
            }
            
            fclose($handle);

            if (count($errors) > 0) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'CSV Import aborted due to validation errors.')
                    ->with('import_errors', $errors);
            }

            DB::commit();
            return redirect()->route('employees.index')->with('success', "Imported {$importedCount} employees successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return redirect()->back()->with('error', 'Error occurred during import: ' . $e->getMessage());
        }
    }

    /**
     * Download the bulk upload CSV template.
     */
    public function downloadTemplate()
    {
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=employee_template.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['emp_id', 'name', 'email', 'department', 'designation', 'emp_role', 'doj', 'password'];

        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            
            // Add sample data values
            fputcsv($file, ['EMP101', 'Alice Smith', 'alice.smith@example.com', 'Engineering', 'Tech Lead', 'Laravel Architect', '2026-06-01', 'secret123']);
            fputcsv($file, ['EMP102', 'Bob Johnson', 'bob.johnson@example.com', 'Design', 'Senior UI Designer', 'Product Specialist', '2026-06-15', 'password123']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
