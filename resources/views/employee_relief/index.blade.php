@extends('layouts.main_hr')
@section('xara_cbs')
    <?php
    function asMoney($value) {
        return number_format($value, 2);
    }
    ?>

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
                                            <h5 class="mb-0"><i class="feather icon-percent mr-2 text-primary"></i>Employee Reliefs</h5>
                                            <small class="text-muted">Manage employee tax relief records</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a class="btn btn-primary btn-sm" href="{{ URL::to('employee_relief/create')}}">
                                                <i class="feather icon-plus mr-1"></i> New Employee Relief
                                            </a>
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
                                        <table id="employeeReliefsTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employee</th>
                                                    <th>Relief Type</th>
                                                    <th>Percentage (%)</th>
                                                    <th>Insurance Premium</th>
                                                    <th>Amount</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @forelse($rels as $rel)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        @if($rel->middle_name == null || $rel->middle_name == '')
                                                            <td>{{ $rel->first_name.' '.$rel->last_name }}</td>
                                                        @else
                                                            <td>{{ $rel->first_name.' '.$rel->middle_name.' '.$rel->last_name }}</td>
                                                        @endif
                                                        <td><span class="badge badge-info">{{ $rel->relief_name }}</span></td>
                                                        <td>{{ $rel->percentage }}%</td>
                                                        <td align="right">{{ asMoney((double)$rel->premium) }}</td>
                                                        <td align="right" class="font-weight-bold text-success">{{ asMoney((double)$rel->relief_amount) }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{URL::to('employee_relief/view/'.$rel->id)}}" class="btn btn-outline-info" data-toggle="tooltip" title="View Details">
                                                                    <i class="feather icon-eye"></i>
                                                                </a>
                                                                <a href="{{URL::to('employee_relief/edit/'.$rel->id)}}" class="btn btn-outline-primary" data-toggle="tooltip" title="Edit Relief">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{URL::to('employee_relief/delete/'.$rel->id)}}" class="btn btn-outline-danger" data-toggle="tooltip" title="Delete Relief" onclick="return confirm('Are you sure you want to delete this employee relief?')">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i class="feather icon-file empty-state-icon" style="font-size: 48px; color: #dee2e6;"></i>
                                                                <h4 class="mt-3">No Employee Reliefs Found</h4>
                                                                <p class="text-muted">Get started by adding your first employee relief.</p>
                                                                <a href="{{ URL::to('employee_relief/create')}}" class="btn btn-primary mt-3">
                                                                    <i class="feather icon-plus mr-1"></i> Add Relief
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
        
        .badge {
            font-weight: 500;
            padding: 0.4em 0.6em;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#employeeReliefsTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search employee reliefs...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No employee reliefs available",
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