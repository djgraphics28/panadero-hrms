<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'branch_department')->withTimestamps();
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'branch_employee')->withTimestamps();
    }
}
