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
                                    <h5 class="mb-0"><i class="fas fa-user-tag"></i> Create New Role</h5>
                                </div>
                                
                                <div class="card-body">
                                    {{-- Error messages --}}
                                    @if(count($errors)>0)
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong><i class="fas fa-exclamation-triangle"></i> {{ $error }}</strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif

                                    {{-- Debug Alert (remove after testing) --}}
                                    <div id="debug-alert" class="alert alert-info" style="display:none;"></div>

                                    {{-- Form --}}
                                    <form action="{{ route('roles.store') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        
                                        {{-- Role Name --}}
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label"><strong>Role Name</strong></label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   placeholder="Enter role name (e.g., Admin, Manager)" required>
                                        </div>
                                        
                                        {{-- Permissions Section --}}
                                        <div class="permission-section mb-4 p-3 bg-light rounded">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0"><strong>Permissions</strong></h6>
                                                
                                                {{-- Select All Checkbox --}}
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="select-all">
                                                    <label class="form-check-label" for="select-all">
                                                        Select All
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            {{-- Group permissions by category --}}
                                            @php
                                                $groupedPermissions = [];
                                                foreach($permissions as $value) {
                                                    $category = $value->category ?? 'General';
                                                    $groupedPermissions[$category][] = $value;
                                                }
                                            @endphp
                                            
                                            {{-- Display permissions --}}
                                            @foreach($groupedPermissions as $category => $permissionsGroup)
                                            <div class="mb-3">
                                                <div class="permission-category font-weight-bold text-primary mb-2">
                                                    <i class="fas fa-folder"></i> {{ $category }}
                                                </div>
                                                <div class="row">
                                                    @foreach($permissionsGroup as $permission)
                                                    <div class="col-md-6 col-lg-4 mb-2">
                                                        <div class="permission-item p-2 bg-white rounded shadow-sm">
                                                            <div class="form-check mb-0">
                                                                <input class="form-check-input permission-checkbox" 
                                                                    type="checkbox" name="permission[]" 
                                                                    value="{{ $permission->id }}" 
                                                                    id="permission_{{ $permission->id }}">
                                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                    {{ $permission->display_name }}
                                                                    <small class="text-muted d-block">({{ $category }})</small>
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
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Create Role
                                            </button>
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

{{-- JS --}}
@section('scripts')
<script>
    function initializeSelectAll() {
        // Get elements
        const selectAllCheckbox = document.getElementById('select-all');
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
        const debugAlert = document.getElementById('debug-alert');

        // Debug: Show alert and log
        console.log('DEBUG: Found ' + permissionCheckboxes.length + ' permission checkboxes.');
        if (debugAlert) {
            debugAlert.innerHTML = '<strong>Debug:</strong> Found ' + permissionCheckboxes.length + ' permission checkboxes. If 0, check RoleController::create for $permissions.';
            debugAlert.style.display = 'block';
        }

        // Check if elements exist
        if (!selectAllCheckbox) {
            console.error('DEBUG: #select-all checkbox not found!');
            return;
        }
        if (permissionCheckboxes.length === 0) {
            console.warn('DEBUG: No .permission-checkbox elements found. Check if permissions are loaded.');
            return;
        }

        // Handle Select All
        selectAllCheckbox.addEventListener('change', function() {
            permissionCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            console.log('DEBUG: Select All toggled to ' + this.checked);
        });

        // Handle individual checkboxes
        permissionCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(permissionCheckboxes).every(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
                console.log('DEBUG: Individual checkbox changed. All checked: ' + allChecked);
            });
        });
    }

    // Run on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', initializeSelectAll);

    // Fallback: Retry after 1s in case DOM is delayed
    setTimeout(initializeSelectAll, 1000);
</script>
@endsection

{{-- CSS --}}
<style>
.permission-section {
    background-color: #f8f9fc;
    border-radius: 8px;
}
.permission-item {
    transition: all 0.3s;
}
.permission-item:hover {
    background-color: #f0f8ff;
    transform: translateY(-2px);
}
</style>