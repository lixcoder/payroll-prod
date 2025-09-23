@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0"><i class="feather icon-shield mr-2 text-primary"></i>Role Management</h5>
                                            <small class="text-muted">Manage system roles and permissions</small>
                                        </div>
                                        <a href="{{url('roles/create')}}" class="btn btn-primary">
                                            <i class="feather icon-plus mr-1"></i> Create Role
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($message = Session::get('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="feather icon-check-circle mr-2"></i>
                                                <div>{{ $message }}</div>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="rolesTable" class="table table-hover table-striped">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Role Name</th>
                                                    <th scope="col" class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $count = 1?>
                                                @foreach($roles as $role)
                                                    <tr>
                                                        <td>{{$count++}}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                                                                    <i class="feather icon-shield"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0">{{$role->name}}</h6>
                                                                    <small class="text-muted">Created: {{ $role->created_at->format('M d, Y') }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{URL('roles.show',$role->id)}}" class="btn btn-outline-info" data-toggle="tooltip" title="View Role">
                                                                    <i class="feather icon-eye"></i>
                                                                </a>
                                                                <a href="{{URL('roles.edit',$role->id)}}" class="btn btn-outline-primary" data-toggle="tooltip" title="Edit Role">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <form action="{{URL('roles.destroy',$role->id)}}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger" data-toggle="tooltip" title="Delete Role" onclick="return confirm('Are you sure you want to delete this role?')">
                                                                        <i class="feather icon-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($roles->hasPages())
                                        <div class="d-flex justify-content-center mt-4">
                                            <nav>
                                                {{ $roles->links('vendor.pagination.bootstrap-4') }}
                                            </nav>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-header {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #2c3e50;
            background-color: #f8f9fa;
        }
        
        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .btn-group .btn {
            margin-right: 0.25rem;
            border-radius: 4px;
        }
        
        .btn-group .btn:last-child {
            margin-right: 0;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTable if there are roles
            @if($roles->count() > 0)
                $('#rolesTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    order: [[0, 'asc']],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search roles...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)",
                        emptyTable: "No roles available",
                        paginate: {
                            previous: "<i class='feather icon-chevron-left'></i>",
                            next: "<i class='feather icon-chevron-right'></i>"
                        }
                    }
                });
            @endif
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection