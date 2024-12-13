<?php

namespace App\Livewire\Administration;

use Livewire\Component;
use App\Models\Designation;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DesignationComponent extends Component
{
    use WithPagination, LivewireAlert;

    public $search = '';
    public $sortColumn = 'name';
    public $sortDirection = 'asc';
    public $name;
    public $designationId;
    public $isEdit = false;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'delete'
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

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
        $this->reset(['name', 'designationId', 'isEdit']);
        $this->dispatch('closeModal');
        $this->resetErrorBag();
    }

    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->reset(['name', 'designationId', 'isEdit']);
        $this->dispatch('openModal');
    }

    public function openEditModal($id)
    {
        $this->resetErrorBag();
        $this->designationId = $id;
        $this->name = Designation::findOrFail($id)->name;
        $this->isEdit = true;
        $this->dispatch('openModal');
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            Designation::findOrFail($this->designationId)->update(['name' => $this->name]);
            $this->alert('success', 'Designation updated successfully!');
        } else {
            Designation::create(['name' => $this->name]);
            $this->alert('success', 'Designation created successfully!');
        }

        $this->dispatch('closeModal');
    }

    public function confirmDelete($id)
    {
        $this->designationId = $id;

        // Ensure you're using the alert method properly
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
        Designation::findOrFail($this->designationId)->delete();
        $this->alert('success', 'Designation deleted successfully!');
    }

    public function render()
    {
        $designations = Designation::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate(10);

        return view('livewire.administration.designation-component', compact('designations'));
    }
}
