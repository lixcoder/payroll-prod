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
                                            <h5 class="mb-0"><i class="feather icon-dollar-sign mr-2 text-primary"></i>Employee Non-Taxable Incomes</h5>
                                            <small class="text-muted">Manage employee non-taxable income records</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a class="btn btn-primary btn-sm" href="{{ URL::to('employeenontaxables/create')}}">
                                                <i class="feather icon-plus mr-1"></i> New Non-Taxable Income
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
                                        <table id="nontaxableTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employee</th>
                                                    <th>Non-Taxable Income</th>
                                                    <th>Amount</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($nontaxables as $nontaxable)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        @if($nontaxable->middle_name == null || $nontaxable->middle_name == '')
                                                            <td>{{ $nontaxable->first_name.' '.$nontaxable->last_name }}</td>
                                                        @else
                                                            <td>{{ $nontaxable->first_name.' '.$nontaxable->middle_name.' '.$nontaxable->last_name }}</td>
                                                        @endif
                                                        <td><span class="badge badge-info">{{ $nontaxable->name }}</span></td>
                                                        <td align="right" class="font-weight-bold text-success">{{ asMoney((double)$nontaxable->nontaxable_amount) }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{URL::to('employeenontaxables/view/'.$nontaxable->id)}}" class="btn btn-outline-info" data-toggle="tooltip" title="View Details">
                                                                    <i class="feather icon-eye"></i>
                                                                </a>
                                                                <a href="{{URL::to('employeenontaxables/edit/'.$nontaxable->id)}}" class="btn btn-outline-primary" data-toggle="tooltip" title="Edit Income">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{URL::to('employeenontaxables/delete/'.$nontaxable->id)}}" class="btn btn-outline-danger" data-toggle="tooltip" title="Delete Income" onclick="return confirm('Are you sure you want to delete this employee non-taxable income?')">
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
            $('#nontaxableTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search non-taxable incomes...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No non-taxable incomes available",
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