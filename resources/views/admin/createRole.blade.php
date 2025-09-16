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
                                    @if(count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong><i class="fas fa-exclamation-triangle"></i> {{ $error }}</strong>
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
                                            <label for="name" class="form-label"><strong>Role Name</strong></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Enter role name (e.g., Admin, Manager)" required>
                                        </div>

                                        {{-- Permissions Section --}}
                                        <div class="permission-section mb-4 p-3 bg-light rounded">
                                            <h6 class="mb-3"><strong>Permissions</strong></h6>

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
                                                <div class="mb-4 border rounded p-3 bg-white shadow-sm">
                                                    <div class="permission-category font-weight-bold text-primary mb-2">
                                                        <i class="fas fa-folder"></i> {{ $category }}
                                                        <small class="text-muted">({{ count($permissionsGroup) }})</small>
                                                    </div>

                                                    <div class="row">
                                                        @foreach($permissionsGroup as $permission)
                                                            <div class="col-md-6 col-lg-4 mb-2">
                                                                <div class="permission-item p-2 bg-light rounded">
                                                                    <div class="form-check mb-0">
                                                                        <input
                                                                            class="form-check-input permission-checkbox"
                                                                            type="checkbox"
                                                                            name="permission[]"
                                                                            value="{{ $permission->id }}"
                                                                            id="permission_{{ $permission->id }}">
                                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                            {{ $permission->display_name }}
                                                                            <small class="text-muted d-block">({{ $permission->name }})</small>
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
