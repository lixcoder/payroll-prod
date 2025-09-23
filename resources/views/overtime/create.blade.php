@extends('layouts.main_hr')
@section('xara_cbs')
<?php function asMoney($value) { return number_format($value, 2); } ?>
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
                                        <h5 class="mb-0"><i class="feather icon-clock mr-2 text-primary"></i>New Employee Overtime</h5>
                                        <small class="text-muted">Create a new overtime record for an employee</small>
                                    </div>
                                    <div class="card-header-right">
                                        <a class="btn btn-outline-secondary btn-sm" href="{{ URL::previous() }}">
                                            <i class="feather icon-arrow-left mr-1"></i> Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($errors)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-x-circle mr-2"></i>{{ $error }}
                                        </div>
                                    @endforeach
                                @endif

                                <form method="POST" action="{{ URL::to('overtimes') }}" accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="employee">Employee <span style="color:red">*</span></label>
                                                <select name="employee" id="employee" class="form-control" onchange="selectEmployee()">
                                                    <option value="">Select Employee</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">
                                                            {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type">Type <span style="color:red">*</span></label>
                                                <select name="type" id="type" class="form-control" onchange="selectEmployee()">
                                                    <option value="">Select Type</option>
                                                    <option value="Hourly">Hourly</option>
                                                    <option value="Daily">Daily</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="period">Period Worked <span style="color:red">*</span></label>
                                                <input class="form-control" placeholder="Enter period" type="text" 
                                                       name="period" id="period" onkeypress="totalB()" onkeyup="totalB()" 
                                                       value="{{ old('period') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="formular">Formular <span style="color:red">*</span></label>
                                                <select name="formular" id="formular" class="form-control">
                                                    <option value="">Select Formular</option>
                                                    <option value="One Time">One Time</option>
                                                    <option value="Recurring">Recurring</option>
                                                    <option value="Instalments">Instalments</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group insts" id="insts" style="display: none;">
                                                <label for="instalments">Instalments</label>
                                                <input class="form-control" placeholder="Enter instalments" 
                                                       onkeypress="totalBalance()" onkeyup="totalBalance()" 
                                                       type="text" name="instalments" id="instalments" value="{{ old('instalments') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <div class="input-group">
                                                    @if(isset($currency) && $currency->shortname)
                                                        <span class="input-group-addon">{{ $currency->shortname }}</span>
                                                    @endif
                                                    <input class="form-control" placeholder="0.00" type="text" 
                                                           name="amount" id="amount" onkeypress="totalBalance()" onkeyup="totalBalance()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total">Total Amount</label>
                                                <div class="input-group">
                                                    @if(isset($currency) && $currency->shortname)
                                                        <span class="input-group-addon">{{ $currency->shortname }}</span>
                                                    @endif
                                                    <input class="form-control" placeholder="" readonly type="text" 
                                                           name="total" id="total" value="{{ old('total') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="odate">Overtime Date <span style="color:red">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="feather icon-calendar"></i></span>
                                                    <input class="form-control expiry" placeholder="Select date" 
                                                           type="text" name="odate" id="odate" value="{{ old('odate') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="feather icon-check-circle mr-1"></i> Create Overtime
                                        </button>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
<script src="{{ asset('datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<style>
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
    }
    
    .form-control, .form-select {
        border-radius: 4px;
        padding: 8px 12px;
        border: 1px solid #dce1e6;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }
    
    .input-group-addon {
        background-color: #f8f9fa;
        border: 1px solid #dce1e6;
        color: #6c757d;
        padding: 8px 12px;
    }
    
    .btn {
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: 500;
    }
    
    .alert {
        border-radius: 4px;
        border: none;
        padding: 12px 16px;
    }
</style>

<script>
    function selectEmployee() {
        var id = document.getElementById('employee').value;
        var type = document.getElementById('type').value;
        
        if (id && type) {
            $.ajax({
                url: '{{ url("overtime_setting/fetch") }}/' + id,
                type: "GET",
                data: '_token=<?php echo csrf_token()?>',
                success: function (response) {
                    calcs(response);
                },
                error: function() {
                    toastr.error('Error fetching employee data');
                }
            });
        } else {
            toastr.info('Please select both employee and type');
        }
    }

    function calcs(salary) {
        const salaryData = {
            type: document.getElementById('type').value,
            salary: salary,
            _token: "{{ csrf_token() }}"
        };
        
        $.ajax({
            url: '{{ url("overtime_setting/fetch") }}',
            type: "GET",
            data: salaryData,
            success: function (response) {
                document.getElementById('amount').value = response;
                totalB(); // Recalculate total after setting amount
            },
            error: function() {
                toastr.error('Error calculating overtime amount');
            }
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#insts').hide();
        
        $('#formular').change(function () {
            if ($(this).val() == "Instalments") {
                $('#insts').show();
            } else {
                $('#insts').hide();
                $('#instalments').val(1);
                totalBalance();
            }
        });

        $('.expiry').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '0y',
            autoclose: true
        });
    });

    function totalBalance() {
        var p = document.getElementById("period").value;
        var instals = document.getElementById("instalments").value;
        var amt = document.getElementById("amount").value.replace(/,/g, '');
        var total = instals * amt * p;
        total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById("total").value = total;
    }

    function totalB() {
        var p = document.getElementById("period").value;
        var amt = document.getElementById("amount").value.replace(/,/g, '');
        var total = p * amt;
        total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById("total").value = total;
    }
</script>
@endsection