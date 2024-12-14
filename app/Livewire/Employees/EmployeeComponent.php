<?php

namespace App\Livewire\Employees;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
use App\Imports\EmployeeImport;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeStatus;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EmployeeComponent extends Component
{
    use WithPagination, LivewireAlert;

    public $search = '';
    public $sortColumn = 'employee_number';
    public $sortDirection = 'asc';
    public $employeeData = [];
    public $employeeId;
    public $isEdit = false;

    public $importFile;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['delete'];

    protected $rules = [
        'employeeData.first_name' => 'required|string|max:255',
        'employeeData.middle_name' => 'nullable|string|max:255',
        'employeeData.last_name' => 'required|string|max:255',
        'employeeData.suffix' => 'nullable|string|max:255',
        // 'employeeData.gender' => 'required|in:Male,Female',
        'employeeData.birth_date' => 'nullable|date',
        'employeeData.contact_number' => 'nullable|string|max:255',
        'employeeData.address' => 'nullable|string|max:255',
        // 'employeeData.civil_status' => 'required|in:Single,Married,Widowed,Separated,Divorced',
        'employeeData.date_hired' => 'nullable|date',
        'employeeData.regularization_date' => 'nullable|date',
        'employeeData.department_id' => 'nullable|exists:departments,id',
        'employeeData.designation_id' => 'nullable|exists:designations,id',
        'employeeData.employee_status_id' => 'nullable|exists:employee_statuses,id',
    ];
    public $employeeStatuses; // To store the statuses
    public $designations;  // To store the designations
    public $departments;  // To store the departments

    public function mount()
    {
        // Fetch all employee statuses from the employee_statuses table
        $this->employeeStatuses = EmployeeStatus::all();
        $this->designations = Designation::all();
        $this->departments = Department::all();
          // If the modal is for creating a new employee
        if (!$this->isEdit) {
            $this->employeeData['employee_number'] = $this->generateEmployeeNumber();
        }
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($column)
    {
        $this->sortDirection = $this->sortColumn === $column && $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->sortColumn = $column;
    }

    public function closeModal()
    {
        $this->reset(['employeeData', 'employeeId', 'isEdit']);
        $this->dispatch('closeModal');
    }

    public function openCreateModal()
    {
        // Reset the necessary properties
        $this->reset(['employeeData', 'employeeId', 'isEdit']);
        
        // Generate the employee number when opening the modal
        $this->employeeData['employee_number'] = $this->generateEmployeeNumber();
    
        // Dispatch event to show the modal
        $this->dispatch('openModal');
    }

    public function openEditModal($id)
    {
        $employee = Employee::findOrFail($id);
        $this->employeeData = $employee->toArray();
        $this->employeeId = $id;
        $this->isEdit = true;
        $this->dispatch('openModal');
    }

    public function save()
    {
        // Validate the input data
        $this->validate([
            'employeeData.employee_number' => 'required|unique:employees,employee_number,' . ($this->isEdit ? $this->employeeId : 'NULL') . '|max:255',
            'employeeData.first_name' => 'required|max:255',
            'employeeData.last_name' => 'required|max:255',
            // Add other fields and rules...
        ]);
    
        if ($this->isEdit) {
            // Update existing employee if editing
            Employee::findOrFail($this->employeeId)->update($this->employeeData);
            $this->alert('success', 'Employee updated successfully!');
        } else {
            // Create new employee if not editing
            Employee::create($this->employeeData);
            $this->alert('success', 'Employee created successfully!');
        }
    
        // Close the modal after save
        $this->dispatch('closeModal');
    }
    

    public function openImportModal()
    {
        $this->reset(['importFile']);
        $this->dispatch('openImportModal');
    }

    public function closeImportModal()
    {
        $this->dispatch('closeImportModal');
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:csv,xlsx|max:2048',
        ]);

        Excel::import(new EmployeeImport, $this->importFile);

        $this->alert('success', 'Employees imported successfully!');
        $this->closeImportModal();
    }

    public function confirmDelete($id)
    {
        $this->employeeId = $id;

        $this->alert('warning', 'Are you sure?', [
            'position' => 'center',
            'timer' => null,
            'showCancelButton' => true,
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes, delete it!',
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'delete',
            'confirmButtonColor' => '#3085d6',
            'cancelButtonColor' => '#d33'
        ]);
    }

    public function delete()
    {
        Employee::findOrFail($this->employeeId)->delete();
        $this->alert('success', 'Employee deleted successfully!');
    }

    public function render()
    {
        $employees = Employee::query()
            ->where('employee_number', 'like', '%' . $this->search . '%')
            ->orWhere('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.employees.employee-component', compact('employees'));
    }


    public function generateEmployeeNumber()
    {
        // Example: generate the employee number based on the latest one in the database
        $latestEmployee = Employee::orderBy('employee_number', 'desc')->first();
        $lastEmployeeNumber = $latestEmployee ? (int) substr($latestEmployee->employee_number, -4) : 0;
    
        // Increment the last employee number, e.g., EMP-0001, EMP-0002
        $newEmployeeNumber = str_pad($lastEmployeeNumber + 1, 4, '0', STR_PAD_LEFT);
    
        return 'EMP-' . $newEmployeeNumber;
    }
}
