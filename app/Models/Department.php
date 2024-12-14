<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['name']; 
    
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_department')->withTimestamps();
    }

    /**
     * Get all of the employees for the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }
}
