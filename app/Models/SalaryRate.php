<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryRate extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all of the employeeRates for the SalaryRate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employeeRates(): HasMany
    {
        return $this->hasMany(EmployeeRate::class, 'salary_rate_id', 'id');
    }
}
