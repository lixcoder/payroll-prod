@extends('layouts.main')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .shift-table th {
            background-color: #4e73df;
            color: white;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }
        
        .shift-table td {
            text-align: center;
            vertical-align: middle;
        }
        
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        
        .btn-info {
            background-color: #36b9cc;
            border-color: #36b9cc;
        }
        
        .btn-info:hover {
            background-color: #2c9faf;
            border-color: #2c9faf;
        }
        
        .badge-shift {
            background-color: #4e73df;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .time-cell {
            font-size: 12px;
            line-height: 1.4;
            padding: 8px 5px;
        }
        
        .time-in {
            color: #1cc88a;
            font-weight: 600;
        }
        
        .time-out {
            color: #e74a3b;
            font-weight: 600;
        }
        
        .dropdown-menu {
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .dropdown-item {
            padding: 8px 15px;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .alert {
            border-radius: 4px;
            border: none;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .page-title {
            color: #5a5c69;
            font-weight: 600;
            margin-bottom: 20px;
        }
    </style>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-business-time mr-2"></i>Work Shifts Management
                                    </h5>
                                </div>
                                
                                <div class="card-body">
                                    <!-- Flash Messages -->
                                    @if (Session::has('flash_message'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle mr-2"></i>{{ Session::get('flash_message') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    
                                    @if (Session::has('delete_message'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="fas fa-exclamation-circle mr-2"></i>{{ Session::get('delete_message') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    
                                    <!-- Action Button -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <a class="btn btn-info" href="{{ URL::to('timesheet/work_shift/create') }}">
                                            <i class="fas fa-plus-circle mr-2"></i>Add New Shift
                                        </a>
                                        
                                        <div class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            {{ count($shifts) }} shift(s) configured
                                        </div>
                                    </div>
                                    
                                    <!-- Shifts Table -->
                                    <div class="table-responsive">
                                        <table id="shifts-table" class="table table-bordered table-hover shift-table">
                                            <thead>
                                                <tr>
                                                    <th width="40">#</th>
                                                    <th width="150">Shift Name</th>
                                                    <th>Monday</th>
                                                    <th>Tuesday</th>
                                                    <th>Wednesday</th>
                                                    <th>Thursday</th>
                                                    <th>Friday</th>
                                                    <th>Saturday</th>
                                                    <th>Sunday</th>
                                                    <th width="100">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($shifts as $index => $shift)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <span class="badge-shift">{{ $shift->shift_name }}</span>
                                                        </td>
                                                        <td class="time-cell">
                                                            @if($shift->monday_in && $shift->monday_out)
                                                                <span class="time-in">{{ $shift->monday_in }}</span><br>
                                                                <span class="time-out">{{ $shift->monday_out }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="time-cell">
                                                            @if($shift->tuesday_in && $shift->tuesday_out)
                                                                <span class="time-in">{{ $shift->tuesday_in }}</span><br>
                                                                <span class="time-out">{{ $shift->tuesday_out }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="time-cell">
                                                            @if($shift->wednesday_in && $shift->wednesday_out)
                                                                <span class="time-in">{{ $shift->wednesday_in }}</span><br>
                                                                <span class="time-out">{{ $shift->wednesday_out }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="time-cell">
                                                            @if($shift->thursday_in && $shift->thursday_out)
                                                                <span class="time-in">{{ $shift->thursday_in }}</span><br>
                                                                <span class="time-out">{{ $shift->thursday_out }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="time-cell">
                                                            @if($shift->friday_in && $shift->friday_out)
                                                                <span class="time-in">{{ $shift->friday_in }}</span><br>
                                                                <span class="time-out">{{ $shift->friday_out }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="time-cell">
                                                            @if($shift->saturday_in && $shift->saturday_out)
                                                                <span class="time-in">{{ $shift->saturday_in }}</span><br>
                                                                <span class="time-out">{{ $shift->saturday_out }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="time-cell">
                                                            @if($shift->sunday_in && $shift->sunday_out)
                                                                <span class="time-in">{{ $shift->sunday_in }}</span><br>
                                                                <span class="time-out">{{ $shift->sunday_out }}</span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fas fa-cog"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{URL::to('timesheet/work_shift/edit/'.$shift->id)}}">
                                                                        <i class="fas fa-edit mr-2 text-primary"></i>Edit
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-danger" href="{{URL::to('timesheet/work_shift/deactivate/'.$shift->id)}}" onclick="return confirm('Are you sure you want to delete this shift?')">
                                                                        <i class="fas fa-trash-alt mr-2"></i>Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if(count($shifts) === 0)
                                        <div class="text-center py-5">
                                            <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Work Shifts Found</h5>
                                            <p class="text-muted">Get started by creating your first work shift</p>
                                            <a class="btn btn-info mt-2" href="{{ URL::to('timesheet/work_shift/create') }}">
                                                <i class="fas fa-plus-circle mr-2"></i>Create First Shift
                                            </a>
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

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable if needed
            @if(count($shifts) > 0)
                $('#shifts-table').DataTable({
                    responsive: true,
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search shifts...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        paginate: {
                            previous: "Previous",
                            next: "Next"
                        }
                    },
                    columnDefs: [
                        { orderable: false, targets: [9] } // Disable sorting on actions column
                    ]
                });
            @endif
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@stop