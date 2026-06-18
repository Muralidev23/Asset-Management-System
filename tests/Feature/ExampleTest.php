<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that landing page redirects to the login route.
     */
    public function test_landing_page_redirects_to_login()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test that an admin can bulk upload employee details via CSV.
     */
    public function test_admin_can_bulk_upload_employees()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $csvContent = "emp_id,name,email,department,designation,emp_role,doj,password\n" .
                     "EMP101,Alice Smith,alice.smith@example.com,Engineering,Tech Lead,Laravel Architect,2026-06-01,secret123\n" .
                     "EMP102,Bob Johnson,bob.johnson@example.com,Design,Senior UI Designer,Product Specialist,2026-06-15,password123\n";

        $file = UploadedFile::fake()->createWithContent('employees.csv', $csvContent);

        $response = $this->actingAs($admin)
            ->post(route('employees.upload.post'), [
                'csv_file' => $file,
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('employees.index'));
        $response->assertSessionHas('success');

        // Check if employee records are stored in the database
        $this->assertDatabaseHas('users', ['email' => 'alice.smith@example.com', 'role' => 'employee']);
        $this->assertDatabaseHas('employees', ['emp_id' => 'EMP101', 'name' => 'Alice Smith']);
        $this->assertDatabaseHas('users', ['email' => 'bob.johnson@example.com', 'role' => 'employee']);
        $this->assertDatabaseHas('employees', ['emp_id' => 'EMP102', 'name' => 'Bob Johnson']);
    }

    /**
     * Test that an admin can download the CSV template.
     */
    public function test_admin_can_download_csv_template()
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->get(route('employees.download-template'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition', 'attachment; filename=employee_template.csv');
        $this->assertStringContainsString('emp_id,name,email,department,designation,emp_role,doj,password', $response->streamedContent());
    }
}
