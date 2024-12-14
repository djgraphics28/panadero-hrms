<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the employees for the EmployeeStatus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    protected $fillable = ['name'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'employee_status_id', 'id');
    }
}
