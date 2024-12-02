<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Employees\EmployeeComponent;
use App\Livewire\Administration\BranchComponent;
use App\Livewire\Administration\DepartmentComponent;
use App\Livewire\Administration\DesignationComponent;
use App\Livewire\Administration\EmployeeStatusComponent;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('branches', BranchComponent::class)->name('branches');
    Route::get('departments', DepartmentComponent::class)->name('departments');
    Route::get('designations', DesignationComponent::class)->name('designations');
    Route::get('employee-statuses', EmployeeStatusComponent::class)->name('employee-statuses');

    //Employees
    Route::get('employees', EmployeeComponent::class)->name('employees');
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
