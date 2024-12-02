<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    // iwant to make first_name, middle_name, last_name and suffix to be uppercase when insert or update
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = strtoupper($value);
    }
    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = strtoupper($value);
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtoupper($value);
    }
    public function setSuffixAttribute($value)
    {
        $this->attributes['suffix'] = strtoupper($value);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_employee')->withTimestamps();
    }

    /**
     * Get the department that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    /**
     * Get the designation that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }

    /**
     * Get the employee_status that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee_status(): BelongsTo
    {
        return $this->belongsTo(EmployeeStatus::class, 'employee_status_id', 'id');
    }

    /**
     * Get all of the salaryRates for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salaryRates(): HasMany
    {
        return $this->hasMany(EmployeeRate::class, 'employee_id', 'id');
    }

    /**
     * Get all of the bankAccounts for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(EmployeeBankAccount::class, 'employee_id', 'id');
    }

    /**
     * Get the contributions associated with the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contributions(): HasOne
    {
        return $this->hasOne(EmployeeContribution::class, 'employee_id', 'id');
    }

    /**
     * Get all of the allowances for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allowances(): HasMany
    {
        return $this->hasMany(EmployeeAllowance::class, 'employee_id', 'id');
    }

    /**
     * Get all of the remarks for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function remarks(): HasMany
    {
        return $this->hasMany(EmployeeRemark::class, 'employee_id', 'id');
    }
}
