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
                                            <h5 class="mb-0"><i class="feather icon-briefcase mr-2 text-primary"></i>Leave Types</h5>
                                            <small class="text-muted">Manage different types of leave and their entitlements</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a class="btn btn-primary btn-sm" href="{{ url('leavetypes/create')}}">
                                                <i class="feather icon-plus mr-1"></i> New Leave Type
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="leaveTypesTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Leave Type</th>
                                                    <th>Days Entitled</th>
                                                    <th>Holidays</th>
                                                    <th>Weekends</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @forelse($leavetypes as $leavetype)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <span class="font-weight-bold text-primary">{{ $leavetype->name }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-pill badge-info" style="font-size: 14px; padding: 8px 12px;">
                                                                {{ $leavetype->days }} days
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $leavetype->in_holidays ? 'success' : 'secondary' }}">
                                                                {{ $leavetype->in_holidays ? 'Included' : 'Excluded' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $leavetype->in_weekends ? 'success' : 'secondary' }}">
                                                                {{ $leavetype->in_weekends ? 'Included' : 'Excluded' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{URL::to('leavetypes/edit/'.$leavetype->id)}}" 
                                                                   class="btn btn-outline-primary" data-toggle="tooltip" title="Edit Leave Type">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{URL::to('leavetypes/delete/'.$leavetype->id)}}" 
                                                                   class="btn btn-outline-danger" data-toggle="tooltip" title="Delete Leave Type"
                                                                   onclick="return confirm('Are you sure you want to delete this leave type?')">
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
                                                                <i class="feather icon-briefcase empty-state-icon" style="font-size: 48px; color: #dee2e6;"></i>
                                                                <h4 class="mt-3">No Leave Types Found</h4>
                                                                <p class="text-muted">Get started by creating your first leave type.</p>
                                                                <a href="{{ url('leavetypes/create')}}" class="btn btn-primary mt-3">
                                                                    <i class="feather icon-plus mr-1"></i> Create Leave Type
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
            $('#leaveTypesTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search leave types...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No leave types available",
                    paginate: {
                        previous: "<i class='feather icon-chevron-left'></i>",
                        next: "<i class='feather icon-chevron-right'></i>"
                    }
                }
            });
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop