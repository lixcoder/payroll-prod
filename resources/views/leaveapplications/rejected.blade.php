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
                                            <h5 class="mb-0"><i class="feather icon-x-circle mr-2 text-danger"></i>Rejected Leaves</h5>
                                            <small class="text-muted">View and manage rejected leave applications</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="rejectedLeavesTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Employee #</th>
                                                    <th>Employee</th>
                                                    <th>Leave Type</th>
                                                    <th>Rejection Date</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Days</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($leaveapplications as $leaveapplication)
                                                    @if($leaveapplication->status == 'rejected')
                                                        <tr>
                                                            <td>{{$leaveapplication->employee->personal_file_number}}</td>
                                                            <td>{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->last_name." ".$leaveapplication->employee->middle_name}}</td>
                                                            <td><span class="badge badge-info">{{$leaveapplication->leavetype->name}}</span></td>
                                                            <td>{{ \Carbon\Carbon::parse($leaveapplication->date_rejected)->format('M d, Y') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($leaveapplication->applied_start_date)->format('M d, Y') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($leaveapplication->applied_end_date)->format('M d, Y') }}</td>
                                                            <td><span class="badge badge-primary">{{App\models\Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date)}}</span></td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <a href="{{url('leaveapplications/edit/'.$leaveapplication->id)}}" 
                                                                       class="btn btn-outline-primary" data-toggle="tooltip" title="Amend Application">
                                                                        <i class="feather icon-edit"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i class="feather icon-check-circle empty-state-icon" style="font-size: 48px; color: #dee2e6;"></i>
                                                                <h4 class="mt-3">No Rejected Leaves</h4>
                                                                <p class="text-muted">There are no rejected leave applications at this time.</p>
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
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
            border-bottom: 1px solid #dee2e6;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#rejectedLeavesTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[3, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search rejected leaves...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No rejected leaves available",
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
@endsection