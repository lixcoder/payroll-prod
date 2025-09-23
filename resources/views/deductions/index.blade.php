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
                                            <h5 class="mb-0"><i class="feather icon-minus-circle mr-2 text-primary"></i>Deductions</h5>
                                            <small class="text-muted">Manage employee deduction types</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a class="btn btn-primary btn-sm" href="{{ URL::to('deductions/create')}}">
                                                <i class="feather icon-plus mr-1"></i> New Deduction
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
                                        <table id="deductionsTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Deduction Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($deductions as $deduction)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $deduction->deduction_name }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{URL::to('deductions/edit/'.$deduction->id)}}" class="btn btn-outline-primary" data-toggle="tooltip" title="Edit Deduction">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{URL::to('deductions/delete/'.$deduction->id)}}" class="btn btn-outline-danger" data-toggle="tooltip" title="Delete Deduction" onclick="return confirm('Are you sure you want to delete this deduction?')">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
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
            $('#deductionsTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search deductions...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No deductions available",
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