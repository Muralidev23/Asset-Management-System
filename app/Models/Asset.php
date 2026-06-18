<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'name',
        'type',
        'serial_number',
        'status',
        'assigned_to',
        'history',
    ];

    protected $casts = [
        'history' => 'array',
    ];

    /**
     * Get the employee to whom the asset is assigned.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }
}
