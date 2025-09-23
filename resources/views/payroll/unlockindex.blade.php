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
                                            <h5 class="mb-0"><i class="feather icon-unlock mr-2 text-primary"></i>Unlock Payroll</h5>
                                            <small class="text-muted">Manage payroll locking and unlocking</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('notice'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i>{{ Session::get('notice') }}
                                        </div>
                                    @endif
                                    
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-x-circle mr-2"></i>{{ Session::get('error') }}
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="payrollsTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Period</th>
                                                    <th>Processed By</th>
                                                    <th>Status</th>
                                                    <th>Unlocked To</th>
                                                    <th>Unlocked By</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($transacts as $transact)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <span class="badge badge-info">
                                                                {{ \Carbon\Carbon::createFromFormat('m-Y', $transact->financial_month_year)->format('F Y') }}
                                                            </span>
                                                        </td>
                                                        <td>{{ App\Models\Transact::getUser($transact->user_id) }}</td>
                                                        <td>
                                                            @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) == 0)
                                                                <span class="badge badge-danger">Locked</span>
                                                            @else
                                                                <span class="badge badge-success">Unlocked</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) > 0)
                                                                {{ App\Models\Lockpayroll::getEmployee($transact->financial_month_year) }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) > 0)
                                                                {{ App\Models\Lockpayroll::getUser($transact->financial_month_year) }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <a href="{{ URL::to('payroll/view/'.$transact->id) }}" 
                                                                   class="btn btn-outline-info" data-toggle="tooltip" title="View Details">
                                                                    <i class="feather icon-eye"></i>
                                                                </a>
                                                                @if(App\Models\Lockpayroll::checkAvailable($transact->financial_month_year) == 0)
                                                                    <a href="{{ URL::to('unlockpayroll/'.$transact->id) }}" 
                                                                       class="btn btn-outline-warning" data-toggle="tooltip" title="Unlock Payroll"
                                                                       onclick="return confirm('Are you sure you want to unlock this payroll?')">
                                                                        <i class="feather icon-unlock"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $transacts->links() }}
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
            padding: 0.5em 0.8em;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #2c3e50;
            background-color: #f8f9fa;
        }
        
        .btn-group-sm > .btn {
            padding: 0.25rem 0.5rem;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#payrollsTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search payrolls...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No payroll records available",
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
@endsection