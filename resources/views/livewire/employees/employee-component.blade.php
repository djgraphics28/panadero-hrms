<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Employees</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between mb-3">
        <input type="text" wire:model.live="search" placeholder="Search..." class="form-control w-25">
        <div>
            <a href="#" class="btn btn-primary">Add Employee</a>
            <button class="btn btn-success" wire:click="openImportModal">Import Excel/CSV</button>
        </div>
    </div>

    <div class="position-relative">
        <div class="table-responsive" style="max-height: 500px;">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="position: sticky; left: 0; background: white; z-index: 2;">
                    <input type="checkbox" wire:model="selectAll">
                </th>
                <th style="position: sticky; left: 40px; background: white; z-index: 2;">#</th>
                <th style="position: sticky; left: 100px; background: white; z-index: 2;" wire:click="sortBy('full_name')" style="cursor: pointer;">Full Name</th>
                <th wire:click="sortBy('email')" style="cursor: pointer;">Email</th>
                <th wire:click="sortBy('phone')" style="cursor: pointer;">Phone</th>
                <th wire:click="sortBy('department')" style="cursor: pointer;">Department</th>
                <th wire:click="sortBy('designation_id')" style="cursor: pointer;">Designation</th>
                <th wire:click="sortBy('employee_status_id')" style="cursor: pointer;">Employee Status</th>
                <th wire:click="sortBy('rate')" style="cursor: pointer;">Rate</th>
                <th wire:click="sortBy('position')" style="cursor: pointer;">Position</th>
                <th wire:click="sortBy('status')" style="cursor: pointer;">Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                <tr>
                    <td style="position: sticky; left: 0; background: white;">
                        <input type="checkbox" wire:model="selected" value="{{ $employee->id }}">
                    </td>
                    <td style="position: sticky; left: 40px; background: white;">{{ $employee->employee_number }}</td>
                    <td style="position: sticky; left: 100px; background: white;">
                        <div class="d-flex align-items-center">
                            <img src="{{ $employee->picture_url }}" class="rounded-circle me-2" width="40" height="40" alt="Profile picture">
                            {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }} {{ $employee->suffix }}
                        </div>
                    </td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->status }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" wire:click="openEditModal({{ $employee->id }})">Edit</button>
                        <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $employee->id }})">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>    </div>

    {{ $employees->links() }}

    <!-- Import Modal -->
    <div id="importModal" class="modal fade" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Employees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeImportModal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="file" wire:model="importFile" accept=".csv, .xlsx" class="form-control">
                    @error('importFile') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="closeImportModal">Cancel</button>
                    <button type="button" class="btn btn-success" wire:click="import">Import</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="crudModal" class="modal fade" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEdit ? 'Edit' : 'Add' }} Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Fields -->
                    <div class="mb-3">
                        <label for="employee_number" class="form-label">Employee Number</label>
                        <input type="text" id="employee_number" wire:model="employeeData.employee_number"
                            class="form-control @error('employeeData.employee_number') is-invalid @enderror">
                        @error('employeeData.employee_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Add more form fields as necessary -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        wire:click="closeModal">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="save">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('openImportModal', () => $('#importModal').modal('show'));
        window.addEventListener('closeImportModal', () => $('#importModal').modal('hide'));
    </script>
</div>
