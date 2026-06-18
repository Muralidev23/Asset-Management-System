<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'emp_id',
        'name',
        'department',
        'designation',
        'emp_role',
        'doj',
    ];

    /**
     * Get the user account associated with the employee.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assets assigned to the employee.
     */
    public function assets()
    {
        return $this->hasMany(Asset::class, 'assigned_to');
    }
}
