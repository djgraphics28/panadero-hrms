<div>

    @section('preloader')
        <i class="fas fa-4x fa-spin fa-spinner text-secondary"></i>
        <h4 class="mt-4 text-dark">Loading</h4>
    @stop
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Designations</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between mb-3">
        <input type="text" wire:model.live="search" placeholder="Search..." class="form-control w-25">
        <button class="btn btn-primary" wire:click="openCreateModal">Add Designation</button>
    </div>

    <div class="position-relative">
        <!-- Loader -->
        {{-- <div wire:loading wire:target="search, sortBy"
            class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center"
            style="background: rgba(255,255,255,0.8); z-index: 1;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> --}}
        <!-- Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="10%" wire:click="sortBy('id')" style="cursor: pointer;">#</th>
                    <th wire:click="sortBy('name')" style="cursor: pointer;">Name</th>
                    <th width="10%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($designations as $designation)
                    <tr>
                        <td>{{ $designation->id }}</td>
                        <td>{{ $designation->name }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                wire:click="openEditModal({{ $designation->id }})">Edit</button>
                            <button class="btn btn-sm btn-danger"
                                wire:click="confirmDelete({{ $designation->id }})">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $designations->links() }}

    <!-- Modal -->
    <div id="crudModal" class="modal fade" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEdit ? 'Edit' : 'Add' }} Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" wire:model="name"
                            class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
        window.addEventListener('openModal', () => $('#crudModal').modal('show'));
        window.addEventListener('closeModal', () => $('#crudModal').modal('hide'));
    </script>
</div>
