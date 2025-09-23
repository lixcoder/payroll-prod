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
                                            <h5 class="mb-0"><i class="feather icon-gavel mr-2 text-primary"></i>Employee Court Orders</h5>
                                            <small class="text-muted">Manage court order assignments to employees</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ url('employee_court_orders/create') }}" class="btn btn-primary btn-sm">
                                                <i class="feather icon-plus mr-1"></i> New Court Order
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i>{{ Session::get('flash_message') }}
                                        </div>
                                    @endif

                                    @if(Session::has('delete_message'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-x-circle mr-2"></i>{{ Session::get('delete_message') }}
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="courtOrdersTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employee</th>
                                                    <th>Court Order</th>
                                                    <th>Deduction</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($employeeCourtOrders as $eco)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="mr-2">
                                                                    <i class="feather icon-user text-primary"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="font-weight-bold">{{ $eco->employee->first_name }} {{ $eco->employee->last_name }}</div>
                                                                    <small class="text-muted">{{ $eco->employee->personal_file_number }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-info">{{ $eco->courtOrder->order_number }}</span>
                                                        </td>
                                                        <td>
                                                            @if($eco->courtOrder->order_type === 'fixed')
                                                                <span class="font-weight-bold text-danger">
                                                                    {{ number_format($eco->courtOrder->amount, 2) }} 
                                                                    <small>{{ $eco->courtOrder->currency ?? 'KES' }}</small>
                                                                </span>
                                                            @elseif($eco->courtOrder->order_type === 'percentage')
                                                                <span class="font-weight-bold text-danger">
                                                                    {{ $eco->courtOrder->percentage }}% 
                                                                    of {{ ucfirst($eco->courtOrder->apply_on ?? 'gross') }}
                                                                </span>
                                                            @endif

                                                            @if($eco->max_deduction)
                                                                <br><small class="text-muted">Max: {{ number_format($eco->max_deduction, 2) }}</small>
                                                            @endif
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($eco->start_date)->format('M d, Y') }}</td>
                                                        <td>
                                                            @if($eco->end_date)
                                                                {{ \Carbon\Carbon::parse($eco->end_date)->format('M d, Y') }}
                                                            @else
                                                                <span class="badge badge-warning">Ongoing</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($eco->status === 'active')
                                                                <span class="badge badge-success">Active</span>
                                                            @elseif($eco->status === 'inactive')
                                                                <span class="badge badge-secondary">Inactive</span>
                                                            @else
                                                                <span class="badge badge-info">{{ ucfirst($eco->status) }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{ url('employee_court_orders/'.$eco->id.'/edit') }}" 
                                                                   class="btn btn-outline-primary" data-toggle="tooltip" title="Edit">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <form action="{{ url('employee_court_orders/'.$eco->id) }}" 
                                                                      method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger"
                                                                        onclick="return confirm('Are you sure you want to delete this record?');"
                                                                        data-toggle="tooltip" title="Delete">
                                                                        <i class="feather icon-trash-2"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
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
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.4em 0.6em;
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
        
        .alert {
            border-radius: 4px;
            border: none;
            padding: 12px 16px;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#courtOrdersTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search court orders...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No court orders available",
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