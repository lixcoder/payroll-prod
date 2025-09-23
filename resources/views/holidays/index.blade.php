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
                                            <h5 class="mb-0"><i class="feather icon-calendar mr-2 text-primary"></i>Holidays</h5>
                                            <small class="text-muted">Manage company holidays and observances</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a class="btn btn-primary btn-sm" href="{{ url('holidays/create')}}">
                                                <i class="feather icon-plus mr-1"></i> New Holiday
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="holidaysTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Holiday Name</th>
                                                    <th>Holiday Date</th>
                                                    <th>Day of Week</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @forelse($holidays as $holiday)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <span class="font-weight-bold text-primary">{{ $holiday->name }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-info">
                                                                {{ \Carbon\Carbon::parse($holiday->date)->format('M d, Y') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-secondary">
                                                                {{ \Carbon\Carbon::parse($holiday->date)->format('l') }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{URL::to('holidays/edit/'.$holiday->id)}}" 
                                                                   class="btn btn-outline-primary" data-toggle="tooltip" title="Edit Holiday">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{URL::to('holidays/delete/'.$holiday->id)}}" 
                                                                   class="btn btn-outline-danger" data-toggle="tooltip" title="Delete Holiday"
                                                                   onclick="return confirm('Are you sure you want to delete this holiday?')">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i class="feather icon-calendar empty-state-icon" style="font-size: 48px; color: #dee2e6;"></i>
                                                                <h4 class="mt-3">No Holidays Found</h4>
                                                                <p class="text-muted">Get started by adding your first company holiday.</p>
                                                                <a href="{{ url('holidays/create')}}" class="btn btn-primary mt-3">
                                                                    <i class="feather icon-plus mr-1"></i> Add Holiday
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
            $('#holidaysTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[2, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search holidays...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No holidays available",
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