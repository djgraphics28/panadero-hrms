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
            <a wire:click="openCreateModal" class="btn btn-primary">Add Employee</a>
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
                        <th style="position: sticky; left: 100px; background: white; z-index: 2;"
                            wire:click="sortBy('full_name')" style="cursor: pointer;">Full Name</th>
                        <th wire:click="sortBy('email')" style="cursor: pointer;">Email</th>
                        <th wire:click="sortBy('phone')" style="cursor: pointer;">Phone</th>
                        <th wire:click="sortBy('department')" style="cursor: pointer;">Department</th>
                        <th wire:click="sortBy('designation_id')" style="cursor: pointer;">Designation</th>
                        <th wire:click="sortBy('employee_status_id')" style="cursor: pointer;">Employee Status</th>
                        <th wire:click="sortBy('rate')" style="cursor: pointer;">Rate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td style="position: sticky; left: 0; background: white;">
                                <input type="checkbox" wire:model="selected" value="{{ $employee->id }}">
                            </td>
                            <td style="position: sticky; left: 40px; background: white;">
                                {{ $employee->employee_number }}</td>
                            <td style="position: sticky; left: 100px; background: white;">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $employee->picture_url }}" class="rounded-circle me-2" width="40"
                                        height="40" alt="Profile picture">
                                    {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}
                                    {{ $employee->suffix }}
                                </div>
                            </td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->contact_number }}</td>
                            <td>{{ $employee->department->name ?? 'N/A' }}</td> 
                            <td>{{ $employee->designation->name ?? 'N/A' }}</td> 
                            <td>{{ $employee->employee_status->name ?? 'N/A' }}</td>
                            <td></td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    wire:click="openEditModal({{ $employee->id }})">Edit</button>
                                <button class="btn btn-sm btn-danger"
                                    wire:click="confirmDelete({{ $employee->id }})">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
                    @error('importFile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $isEdit ? 'Edit' : 'Add' }} Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Fields with Bootstrap Grid Layout -->
                <div class="row g-3">
                    <!-- Employee Number -->
                    <div class="col-md-6">
                        <label for="employee_number" class="form-label">Employee Number</label>
                        <input type="text" id="employee_number" wire:model="employeeData.employee_number"
                            class="form-control @error('employeeData.employee_number') is-invalid @enderror" readonly>
                        @error('employeeData.employee_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- First Name -->
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" wire:model="employeeData.first_name"
                               class="form-control @error('employeeData.first_name') is-invalid @enderror">
                        @error('employeeData.first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Middle Name -->
                    <div class="col-md-6">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" id="middle_name" wire:model="employeeData.middle_name"
                               class="form-control @error('employeeData.middle_name') is-invalid @enderror">
                        @error('employeeData.middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" wire:model="employeeData.last_name"
                               class="form-control @error('employeeData.last_name') is-invalid @enderror">
                        @error('employeeData.last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Suffix -->
                    <div class="col-md-6">
                        <label for="suffix" class="form-label">Suffix</label>
                        <input type="text" id="suffix" wire:model="employeeData.suffix"
                               class="form-control @error('employeeData.suffix') is-invalid @enderror">
                        @error('employeeData.suffix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" wire:model="employeeData.gender" class="form-control @error('employeeData.gender') is-invalid @enderror">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        @error('employeeData.gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Birth Date -->
                    <div class="col-md-6">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date" id="birth_date" wire:model="employeeData.birth_date"
                               class="form-control @error('employeeData.birth_date') is-invalid @enderror">
                        @error('employeeData.birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-6">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" id="contact_number" wire:model="employeeData.contact_number"
                               class="form-control @error('employeeData.contact_number') is-invalid @enderror">
                        @error('employeeData.contact_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" id="address" wire:model="employeeData.address"
                               class="form-control @error('employeeData.address') is-invalid @enderror">
                        @error('employeeData.address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Civil Status -->
                    <div class="col-md-6">
                        <label for="civil_status" class="form-label">Civil Status</label>
                        <select id="civil_status" wire:model="employeeData.civil_status" class="form-control @error('employeeData.civil_status') is-invalid @enderror">
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                            <option value="Divorced">Divorced</option>
                        </select>
                        @error('employeeData.civil_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Date Hired -->
                    <div class="col-md-6">
                        <label for="date_hired" class="form-label">Date Hired</label>
                        <input type="date" id="date_hired" wire:model="employeeData.date_hired"
                               class="form-control @error('employeeData.date_hired') is-invalid @enderror">
                        @error('employeeData.date_hired')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Regularization Date -->
                    <div class="col-md-6">
                        <label for="regularization_date" class="form-label">Regularization Date</label>
                        <input type="date" id="regularization_date" wire:model="employeeData.regularization_date"
                               class="form-control @error('employeeData.regularization_date') is-invalid @enderror">
                        @error('employeeData.regularization_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div class="col-md-6">
                        <label for="department_id" class="form-label">Department</label>
                        <select id="department_id" wire:model="employeeData.department_id" class="form-control @error('employeeData.department_id') is-invalid @enderror">
                            <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                        </select>
                        @error('employeeData.department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Designation -->
                    <div class="col-md-6">
                        <label for="designation_id" class="form-label">Designation</label>
                        <select id="designation_id" wire:model="employeeData.designation_id" class="form-control @error('employeeData.designation_id') is-invalid @enderror">
                            <option value="">Select Designation</option>
                            @foreach ($designations as $designation)
                                 <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                            @endforeach
                        </select>
                        @error('employeeData.designation_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Employee Status -->
                    <div class="col-md-6">
                        <label for="employee_status_id" class="form-label">Employee Status</label>
                        <select id="employee_status_id" wire:model="employeeData.employee_status_id" class="form-control @error('employeeData.employee_status_id') is-invalid @enderror">
                            <option value="">Select Status</option>
                            @foreach ($employeeStatuses as $status)
                                 <option value="{{ $status->id }}">{{ $status->name }}</option>
                             @endforeach
                        </select>
                        @error('employeeData.employee_status_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cancel</button>
                <button type="button" class="btn btn-primary" wire:click="save">Save</button>
            </div>
        </div>
    </div>
</div>



    <script>
        window.addEventListener('openImportModal', () => $('#importModal').modal('show'));
        window.addEventListener('closeImportModal', () => $('#importModal').modal('hide'));
        window.addEventListener('openModal', () => $('#crudModal').modal('show'));
        window.addEventListener('closeModal', () => $('#crudModal').modal('hide'));
    </script>
</div>
