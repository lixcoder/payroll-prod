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
                                            <h5 class="mb-0"><i class="feather icon-clock mr-2 text-warning"></i>Update Employee Overtime</h5>
                                            <small class="text-muted">Modify employee overtime details</small>
                                        </div>
                                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="feather icon-arrow-left"></i> Back
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ $error }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                    
                                    @if(Session::has('flash_message'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ Session::get('flash_message') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{{ URL::to('overtimes/update/'.$overtime->id) }}}" accept-charset="UTF-8">
                                        @csrf
                                        <input type="hidden" name="employeeid" id="employeeid" value="{{$overtime->employee->id}}">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="employee">Employee <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-user"></i></span>
                                                        </div>
                                                        <input class="form-control" type="text" readonly name="employee" id="employee" value="{{$overtime->employee->first_name.' '.$overtime->employee->last_name}}">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="type">Type <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-cpu"></i></span>
                                                        </div>
                                                        <select name="type" id="type" class="form-control" required>
                                                            <option value="">Select Type</option>
                                                            <option value="Hourly"<?= ($overtime->type == 'Hourly') ? 'selected="selected"' : ''; ?>>Hourly</option>
                                                            <option value="Daily"<?= ($overtime->type == 'Daily') ? 'selected="selected"' : ''; ?>>Daily</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="period">Period Worked <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-watch"></i></span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter period worked" type="number" min="0" step="0.5" name="period" id="period" value="{{$overtime->period}}" onkeyup="totalB()" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="formular">Formular <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-sliders"></i></span>
                                                        </div>
                                                        <select name="formular" id="formular" class="form-control" required>
                                                            <option value="">Select Formular</option>
                                                            <option value="One Time"<?= ($overtime->formular == 'One Time') ? 'selected="selected"' : ''; ?>>One Time</option>
                                                            <option value="Recurring"<?= ($overtime->formular == 'Recurring') ? 'selected="selected"' : ''; ?>>Recurring</option>
                                                            <option value="Instalments"<?= ($overtime->formular == 'Instalments') ? 'selected="selected"' : ''; ?>>Instalments</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6" id="insts" style="display: none;">
                                                <div class="form-group">
                                                    <label for="instalments">Instalments</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-hash"></i></span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter number of instalments" type="number" min="1" name="instalments" id="instalments" value="{{ $overtime->instalments}}" onkeyup="totalBalance()">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{$currency->shortname}}</span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter amount" type="number" min="0" step="0.01" name="amount" id="amount" value="{{$overtime->amount * 100}}" onkeyup="totalBalance()">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="total">Total Amount</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{$currency->shortname}}</span>
                                                        </div>
                                                        <input class="form-control" readonly type="text" name="total" id="total" value="{{asMoney((double)$overtime->amount*(double)$overtime->instalments*(double)$overtime->period)}}">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="odate">Overtime Date <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                        </div>
                                                        <input class="form-control expiry" readonly placeholder="Select date" type="text" name="odate" id="odate" value="{{ $overtime->overtime_date }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-actions form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather icon-check-circle mr-1"></i> Update Overtime
                                            </button>
                                            <a href="{{ URL::to('overtimes') }}" class="btn btn-outline-secondary">
                                                <i class="feather icon-x-circle mr-1"></i> Cancel
                                            </a>
                                        </div>
                                    </form>
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
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        
        .input-group .form-control {
            border-left: none;
            padding-left: 0;
        }
        
        .input-group .form-control:focus {
            border-color: #ced4da;
            box-shadow: none;
        }
        
        .input-group .form-control:focus + .input-group-append .input-group-text {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .btn {
            border-radius: 4px;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }
    </style>

    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    
    <script type="text/javascript">
        function totalBalance() {
            var p = document.getElementById("period").value;
            var instals = document.getElementById("instalments").value;
            var amt = document.getElementById("amount").value;
            var total = instals * amt * p;
            total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById("total").value = total;
        }

        function totalB() {
            var p = document.getElementById("period").value;
            var amt = document.getElementById("amount").value;
            var total = p * amt;
            total = total.toFixed(2);
            document.getElementById("total").value = total;
        }

        $(document).ready(function () {
            // Show/hide instalments field based on formular selection
            if ($('#formular').val() == "Instalments") {
                $('#insts').show();
            } else {
                $('#insts').hide();
            }

            $('#formular').change(function () {
                if ($(this).val() == "Instalments") {
                    $('#insts').show();
                } else {
                    $('#insts').hide();
                    $('#instalments').val(1);
                    totalBalance();
                }
            });

            // Datepicker initialization
            $('.expiry').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

            // Auto-calculate amount based on employee, type and period
            $('#employee, #type, #period').change(function() {
                calculateOvertimeAmount();
            });

            function calculateOvertimeAmount() {
                var employeeId = $('#employeeid').val();
                var type = $('#type').val();
                var period = $('#period').val();
                
                if (employeeId && type && period) {
                    $.get("{{ url('api/pay')}}", 
                        {option: employeeId},
                        function (data) {
                            var payAmount = parseFloat(data.replace(/,/g, ''));
                            
                            if (type == 'Hourly' && period != '') {
                                var hourlyRate = (payAmount / 24 / 30).toFixed(2);
                                $('#amount').val(hourlyRate);
                                $('#total').val((hourlyRate * period).toFixed(2));
                            } else if (type == 'Daily' && period != '') {
                                var dailyRate = (payAmount / 30).toFixed(2);
                                $('#amount').val(dailyRate);
                                $('#total').val((dailyRate * period).toFixed(2));
                            }
                        }
                    );
                }
            }
        });
    </script>
@stop