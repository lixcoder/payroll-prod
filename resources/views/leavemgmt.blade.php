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
                                            <h5 class="mb-0"><i class="feather icon-briefcase mr-2 text-primary"></i>Leave Applications</h5>
                                            <small class="text-muted">Manage employee leave requests and approvals</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a class="btn btn-primary btn-sm" href="{{ url('leaveapplications/create')}}">
                                                <i class="feather icon-plus mr-1"></i> New Application
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (Session::get('notice'))
                                        <div class="alert alert-info alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-info mr-2"></i>{{ Session::get('notice') }}
                                        </div>
                                    @endif
                                    
                                    <div class="table-responsive">
                                        <table id="leaveApplicationsTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Employee #</th>
                                                    <th>Employee</th>
                                                    <th>Leave Type</th>
                                                    <th>Application Date</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Days</th>
                                                    <th>Balance</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($leaveapplications as $leaveapplication)
                                                    @if($leaveapplication->status == 'applied')
                                                        <?php
                                                            $employeeCount = App\Models\Employee::where("id", $leaveapplication->employee_id)->count();
                                                        ?>
                                                        @if($employeeCount>0)
                                                            <tr>
                                                                <td>{{$leaveapplication->employee->personal_file_number}}</td>
                                                                <td>{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->last_name." ".$leaveapplication->employee->middle_name}}</td>
                                                                <td><span class="badge badge-info">{{$leaveapplication->leavetype->name}}</span></td>
                                                                <td>{{ \Carbon\Carbon::parse($leaveapplication->application_date)->format('M d, Y') }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($leaveapplication->applied_start_date)->format('M d, Y') }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($leaveapplication->applied_end_date)->format('M d, Y') }}</td>
                                                                <td><span class="badge badge-primary">{{App\Models\Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date)}}</span></td>
                                                                <td><span class="badge badge-{{App\Models\Leaveapplication::getBalanceDays($leaveapplication->employee, $leaveapplication->leavetype) >= App\Models\Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date) ? 'success' : 'danger'}}">
                                                                    {{App\Models\Leaveapplication::getBalanceDays($leaveapplication->employee, $leaveapplication->leavetype)}}
                                                                </span></td>
                                                                <td><span class="badge badge-warning">Pending</span></td>
                                                                <td>
                                                                    <div class="btn-group btn-group-sm" role="group">
                                                                        <a href="{{url('leaveapplications/edit/'.$leaveapplication->id)}}" 
                                                                           class="btn btn-outline-primary" data-toggle="tooltip" title="Amend">
                                                                            <i class="feather icon-edit"></i>
                                                                        </a>
                                                                        @if(App\Models\Leaveapplication::getBalanceDays($leaveapplication->employee, $leaveapplication->leavetype) >= App\Models\Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date))
                                                                            <a href="{{url('leaveapplications/approve/'.$leaveapplication->id)}}" 
                                                                               class="btn btn-outline-success" data-toggle="tooltip" title="Approve"
                                                                               onclick="return confirm('Are you sure you want to approve this leave application?')">
                                                                                <i class="feather icon-check"></i>
                                                                            </a>
                                                                        @endif
                                                                        <a href="{{url('leaveapplications/reject/'.$leaveapplication->id)}}" 
                                                                           class="btn btn-outline-danger" data-toggle="tooltip" title="Reject"
                                                                           onclick="return confirm('Are you sure you want to reject this leave application?')">
                                                                            <i class="feather icon-x"></i>
                                                                        </a>
                                                                        <a href="{{url('leaveapplications/cancel/'.$leaveapplication->id)}}" 
                                                                           class="btn btn-outline-secondary" data-toggle="tooltip" title="Cancel"
                                                                           onclick="return confirm('Are you sure you want to cancel this leave application?')">
                                                                            <i class="feather icon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @empty
                                                    <tr>
                                                        <td colspan="10" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i class="feather icon-briefcase empty-state-icon" style="font-size: 48px; color: #ccc;"></i>
                                                                <h4 class="mt-3">No Leave Applications</h4>
                                                                <p class="text-muted">No leave applications have been submitted yet.</p>
                                                                <a href="{{ url('leaveapplications/create')}}" class="btn btn-primary mt-3">
                                                                    <i class="feather icon-plus mr-1"></i> Create Application
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
            $('#leaveApplicationsTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[3, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search applications...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No applications available",
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