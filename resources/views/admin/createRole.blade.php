@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 col-lg-10">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0"><i class="fas fa-user-tag mr-2"></i> Create New Role</h5>
                                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-arrow-left mr-1"></i> Back
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    {{-- Error messages --}}
                                    @if(count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                                    <div><strong>{{ $error }}</strong></div>
                                                </div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif

                                    {{-- Form --}}
                                    <form action="{{ route('roles.store') }}" method="post">
                                        @csrf
                                        @method('POST')

                                        {{-- Role Name --}}
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label"><strong>Role Name</strong> <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fas fa-tag text-primary"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder="Enter role name (e.g., Admin, Manager)" required>
                                            </div>
                                        </div>

                                        {{-- Permissions Section --}}
                                        <div class="permission-section mb-4 p-4 bg-light rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0"><strong>Permissions</strong> <span class="text-danger">*</span></h6>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="select-all">
                                                    <label class="form-check-label font-weight-bold" for="select-all">
                                                        <i class="fas fa-check-double mr-1"></i>Select All
                                                    </label>
                                                </div>
                                            </div>

                                            {{-- Group permissions by category --}}
                                            @php
                                                $groupedPermissions = [];
                                                foreach($permissions as $value) {
                                                    $category = $value->category ?? ($value->Category ?? 'General');
                                                    if (!$category) { $category = 'General'; }
                                                    $groupedPermissions[$category][] = $value;
                                                }
                                            @endphp

                                            {{-- Display permissions --}}
                                            @foreach($groupedPermissions as $category => $permissionsGroup)
                                                <div class="mb-4 border-0 rounded p-3 bg-white shadow-sm">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div class="permission-category font-weight-bold text-primary">
                                                            <i class="fas fa-folder mr-2"></i> {{ $category }}
                                                            <small class="text-muted">({{ count($permissionsGroup) }})</small>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input select-group" type="checkbox" 
                                                                   data-group="{{ Str::slug($category) }}"
                                                                   id="group-{{ Str::slug($category) }}">
                                                            <label class="form-check-label small" for="group-{{ Str::slug($category) }}">
                                                                Select Group
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        @foreach($permissionsGroup as $permission)
                                                            <div class="col-md-6 col-lg-4 mb-2">
                                                                <div class="permission-item p-2 bg-light rounded border-0">
                                                                    <div class="form-check mb-0">
                                                                        <input
                                                                            class="form-check-input permission-checkbox group-{{ Str::slug($category) }}"
                                                                            type="checkbox"
                                                                            name="permission[]"
                                                                            value="{{ $permission->id }}"
                                                                            id="permission_{{ $permission->id }}">
                                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                            <span class="d-block font-weight-semibold">{{ $permission->display_name }}</span>
                                                                            <small class="text-muted d-block">{{ $permission->name }}</small>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Submit --}}
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-success btn-lg px-5">
                                                <i class="fas fa-save mr-2"></i> Create Role
                                            </button>
                                            <a href="{{ URL('roles') }}" class="btn btn-outline-secondary btn-lg ml-2 px-4">
                                                <i class="fas fa-times mr-2"></i> Cancel
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- CSS --}}
<style>
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px 10px 0 0;
    }
    
    .permission-section {
        background-color: #f8f9fc;
        border-radius: 10px;
    }
    
    .permission-item {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .permission-item:hover {
        background-color: #f0f8ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.15rem;
    }
    
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }
    
    .alert {
        border: none;
        border-radius: 8px;
        border-left: 4px solid #ffc107;
    }
</style>

{{-- JavaScript --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Select all functionality
        const selectAll = document.getElementById('select-all');
        const groupCheckboxes = document.querySelectorAll('.select-group');
        const allPermissions = document.querySelectorAll('.permission-checkbox');

        // Global select all
        if (selectAll) {
            selectAll.addEventListener('change', function (event) {
                const checked = event.target.checked;
                allPermissions.forEach(cb => cb.checked = checked);
                groupCheckboxes.forEach(cb => cb.checked = checked);
            });
        }

        // Per-group select
        groupCheckboxes.forEach(groupCheckbox => {
            groupCheckbox.addEventListener('change', function (event) {
                const checked = event.target.checked;
                const groupClass = '.group-' + groupCheckbox.dataset.group;
                document.querySelectorAll(groupClass).forEach(cb => cb.checked = checked);
                syncSelectAll();
            });
        });

        // Keep global select-all in sync
        allPermissions.forEach(cb => {
            cb.addEventListener('change', syncSelectAll);
        });

        function syncSelectAll() {
            if (!selectAll) return;
            
            const total = allPermissions.length;
            const checkedCount = document.querySelectorAll('.permission-checkbox:checked').length;
            selectAll.checked = total === checkedCount;
            
            // Also sync group checkboxes
            groupCheckboxes.forEach(groupCheckbox => {
                const groupClass = '.group-' + groupCheckbox.dataset.group;
                const groupPermissions = document.querySelectorAll(groupClass);
                const groupChecked = document.querySelectorAll(groupClass + ':checked');
                groupCheckbox.checked = groupPermissions.length === groupChecked.length;
                groupCheckbox.indeterminate = groupChecked.length > 0 && groupChecked.length < groupPermissions.length;
            });
        }

        // Initialize on load
        syncSelectAll();
    });
</script>