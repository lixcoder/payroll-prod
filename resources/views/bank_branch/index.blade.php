@extends('layouts.main_hr')
@section('xara_cbs')
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
                                            <h5 class="mb-0"><i class="feather icon-git-branch mr-2 text-primary"></i>Bank Branches</h5>
                                            <small class="text-muted">Manage bank branches for payroll processing</small>
                                        </div>
                                        <div class="card-header-right">
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-primary btn-sm mr-2" href="{{ url('bankbranches/create')}}">
                                                    <i class="feather icon-plus mr-1"></i> New Branch
                                                </a>
                                                <a class="btn btn-outline-info btn-sm" href="{{ url('bankbranchesimport')}}">
                                                    <i class="feather icon-upload mr-1"></i> Import
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('flash_message'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i>{{ Session::get('flash_message') }}
                                        </div>
                                    @endif

                                    @if (Session::has('delete_message'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-x-circle mr-2"></i>{{ Session::get('delete_message') }}
                                        </div>
                                    @endif
                                    
                                    <div class="table-responsive">
                                        <table id="bankBranchesTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Bank Branch Code</th>
                                                    <th>Bank Branch Name</th>
                                                    <th>Bank</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @forelse($bbranches as $bbranch)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <span class="badge badge-info">{{ $bbranch->branch_code }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-bold text-primary">{{ $bbranch->bank_branch_name }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-secondary">{{ $bbranch->bank->bank_name ?? 'N/A' }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success">Active</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{url('bankbranches/edit/'.$bbranch->id)}}" 
                                                                   class="btn btn-outline-primary" data-toggle="tooltip" title="Edit Branch">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{url('bankbranches/delete/'.$bbranch->id)}}" 
                                                                   class="btn btn-outline-danger" data-toggle="tooltip" title="Delete Branch"
                                                                   onclick="return confirm('Are you sure you want to delete this bank branch?')">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i class="feather icon-git-branch empty-state-icon" style="font-size: 48px; color: #dee2e6;"></i>
                                                                <h4 class="mt-3">No Bank Branches Found</h4>
                                                                <p class="text-muted">Get started by adding your first bank branch.</p>
                                                                <a href="{{ url('bankbranches/create')}}" class="btn btn-primary mt-3">
                                                                    <i class="feather icon-plus mr-1"></i> Add Branch
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .empty-state {
            padding: 30px 0;
            text-align: center;
        }
        
        .empty-state-icon {
            font-size: 48px;
            color: #dee2e6;
            margin-bottom: 15px;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #2c3e50;
            background-color: #f8f9fa;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.4em 0.6em;
        }
        
        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#bankBranchesTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search bank branches...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No bank branches available",
                    paginate: {
                        previous: "<i class='feather icon-chevron-left'></i>",
                        next: "<i class='feather icon-chevron-right'></i>"
                    }
                }
            });
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@stop