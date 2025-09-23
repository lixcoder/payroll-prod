@extends('layouts.main_hr')
@section('xara_cbs')
    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
    
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
                                            <h5 class="mb-0"><i class="feather icon-mail mr-2 text-primary"></i>Email Payslips</h5>
                                            <small class="text-muted">Manage and send employee payslips via email</small>
                                        </div>
                                        <div class="card-header-right">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#emailPayslip">
                                                <i class="feather icon-send mr-1"></i> Email Payslips
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i>{{ Session::get('success') }}
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="payslipsTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Month</th>
                                                    <th>Employees</th>
                                                    <th>Total Amount</th>
                                                    <th>NHIF</th>
                                                    <th>PAYE</th>
                                                    <th>NSSF</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $count = 1; ?>
                                                @foreach($payslips as $payslip)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td><span class="badge badge-info">{{ $payslip->financial_month_year }}</span></td>
                                                        <td>{{ App\Models\Transact::where('organization_id', Auth::user()->organization_id)->where('financial_month_year', $payslip->financial_month_year)->count() }}</td>
                                                        <td class="text-right font-weight-bold text-success">
                                                            {{ number_format(App\Models\Transact::where('organization_id', Auth::user()->organization_id)->where('financial_month_year', $payslip->financial_month_year)->sum('basic_pay'), 2) }}
                                                        </td>
                                                        <td class="text-right text-danger">
                                                            {{ number_format(App\Models\Transact::where('organization_id', Auth::user()->organization_id)->where('financial_month_year', $payslip->financial_month_year)->sum('nhif_amount'), 2) }}
                                                        </td>
                                                        <td class="text-right text-danger">
                                                            {{ number_format(App\Models\Transact::where('organization_id', Auth::user()->organization_id)->where('financial_month_year', $payslip->financial_month_year)->sum('paye'), 2) }}
                                                        </td>
                                                        <td class="text-right text-danger">
                                                            {{ number_format(App\Models\Transact::where('organization_id', Auth::user()->organization_id)->where('financial_month_year', $payslip->financial_month_year)->sum('nssf_amount'), 2) }}
                                                        </td>
                                                        <td>
                                                            @if(App\Models\Transact::where('organization_id', Auth::user()->organization_id)->where('financial_month_year', $payslip->financial_month_year)->pluck('is_emailed')->first() == 1)
                                                                <span class="badge badge-success">
                                                                    <i class="feather icon-check-circle mr-1"></i> Sent
                                                                </span>
                                                            @else
                                                                <span class="badge badge-warning">
                                                                    <i class="feather icon-clock mr-1"></i> Pending
                                                                </span>
                                                            @endif
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

    <!-- Email Payslip Modal -->
    <div class="modal fade" id="emailPayslip" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="feather icon-mail mr-2 text-primary"></i>Email Payslips</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ URL::to('email/payslip/employees') }}" accept-charset="UTF-8">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="period" class="form-label">Period <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                        </div>
                                        <input required class="form-control datepicker2" placeholder="Select period" 
                                               type="text" name="period" id="period" value="{{ date('m-Y') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="employeeid" class="form-label">Select Employee</label>
                                    <select name="employeeid" class="form-control">
                                        <option value="">All Employees</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->personal_file_number.' - '.$employee->first_name.' '.$employee->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="sel" name="sel" checked>
                                <label class="custom-control-label" for="sel">Send to all employees</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-send mr-1"></i> Send Payslips
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
    <script src="{{ asset('datepicker/js/bootstrap-datepicker.min.js') }}"></script>

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
        
        .modal-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .form-label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #dce1e6;
            color: #6c757d;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize DataTable
            $('#payslipsTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search payslips...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No payslips available",
                    paginate: {
                        previous: "<i class='feather icon-chevron-left'></i>",
                        next: "<i class='feather icon-chevron-right'></i>"
                    }
                }
            });

            $('.datepicker2').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);

            // Select all checkbox functionality
            $('#sel').change(function() {
                if ($(this).is(':checked')) {
                    $('#employeeid').val('').prop('disabled', true);
                } else {
                    $('#employeeid').prop('disabled', false);
                }
            });

            // Initialize select2 for employee selection
            $('#employeeid').select2({
                placeholder: "Select employee",
                allowClear: true,
                width: '100%'
            });
        });

        function YNconfirm() {
            var per = document.getElementById("period").value;
            if (window.confirm('Do you wish to process payroll for ' + per + '?')) {
                window.location.href = "{{ URL::to('payroll/accounts')}}";
            }
        }
    </script>
@endsection