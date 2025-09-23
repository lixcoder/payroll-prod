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
                                        <h5 class="mb-0"><i class="feather icon-plus-circle mr-2 text-primary"></i>New Employee Allowance</h5>
                                        <small class="text-muted">Add a new allowance for an employee</small>
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

                                <div id="dialog-form" title="Create new allowance type" style="display: none;">
                                    <p class="validateTips">Please insert Allowance Type.</p>
                                    <form>
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="name">Name <span style="color:red">*</span></label>
                                                <input type="text" name="name" id="name" value="" class="form-control">
                                            </div>
                                            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                        </fieldset>
                                    </form>
                                </div>

                                <form method="POST" action="{{ URL::to('employee_allowances') }}" accept-charset="UTF-8">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="employee">Employee <span style="color:red">*</span></label>
                                                <select name="employee" class="form-control">
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
                                                <label for="allowance">Allowance Type <span style="color:red">*</span></label>
                                                <select name="allowance" id="allowance" class="form-control">
                                                    <option value="">Select Allowance Type</option>
                                                    <option value="cnew">Create New</option>
                                                    @foreach($allowances as $allowance)
                                                        <option value="{{ $allowance->id }}"> 
                                                            {{ $allowance->allowance_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="formular">Formular <span style="color:red">*</span></label>
                                                <select name="formular" id="formular" class="form-control forml">
                                                    <option value="">Select Formular</option>
                                                    <option value="One Time">One Time</option>
                                                    <option value="Recurring">Recurring</option>
                                                    <option value="Instalments">Instalments</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group insts" id="insts" style="display: none;">
                                                <label for="instalments">Instalments</label>
                                                <input class="form-control" placeholder="Enter number of instalments" 
                                                       onkeypress="totalB()" onkeyup="totalB()" type="text" 
                                                       name="instalments" id="instalments" value="{{ old('instalments') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="amount">Amount <span style="color:red">*</span></label>
                                                <div class="input-group">
                                                    @if(isset($currency) && $currency->shortname)
                                                        <span class="input-group-addon">{{ $currency->shortname }}</span>
                                                    @endif
                                                    <input class="form-control" placeholder="0.00" onkeypress="totalBalance()"
                                                           onkeyup="totalBalance()" type="text" name="amount" id="amount"
                                                           value="{{ old('amount') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bal_amt" id="bal" style="display: none;">
                                                <label for="balance">Total</label>
                                                <div class="input-group">
                                                    @if(isset($currency) && $currency->shortname)
                                                        <span class="input-group-addon">{{ $currency->shortname }}</span>
                                                    @endif
                                                    <input class="form-control" placeholder="" readonly="readonly" 
                                                           type="text" name="balance" id="balance" value="{{ old('balance') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="adate">Allowance Date <span style="color:red">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="feather icon-calendar"></i></span>
                                            <input class="form-control allowancedate" readonly="readonly" placeholder="Select date" 
                                                   type="text" name="adate" id="adate" value="{{ old('adate') }}">
                                        </div>
                                    </div>

                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="feather icon-check-circle mr-1"></i> Create Employee Allowance
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

<link href="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.css') }}" rel="stylesheet">
<script src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
<script src="{{ asset('datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.js') }}"></script>

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
    
    #dialog-form {
        padding: 20px;
        border-radius: 8px;
    }
    
    .ui-dialog {
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .ui-dialog-titlebar {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        border-radius: 8px 8px 0 0;
        padding: 15px 20px;
        font-weight: 600;
    }
    
    .allowancedate {
        background-color: white;
    }
</style>

<script type="text/javascript">
    function totalBalance() {
        var instals = document.getElementById("instalments").value;
        var amt = document.getElementById("amount").value.replace(/,/g, '');
        var total = instals * amt * 10;
        total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById("balance").value = total;
    }

    function totalB() {
        var instals = document.getElementById("instalments").value;
        var amt = document.getElementById("amount").value.replace(/,/g, '');
        var total = instals * amt;
        total = total.toLocaleString('en-US', {minimumFractionDigits: 2});
        document.getElementById("balance").value = total;
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#insts').hide();
        $('#bal').hide();
        
        $('#formular').change(function () {
            if ($(this).val() == "Instalments") {
                $('#insts').show();
                $('#bal').show();
            } else {
                $('#insts').hide();
                $('#bal').hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        $('.allowancedate').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-60y',
            autoclose: true
        });
    });
</script>

<script>
    $(function () {
        var dialog, form,
            name = $("#name"),
            allFields = $([]).add(name),
            tips = $(".validateTips");

        function updateTips(t) {
            tips
                .text(t)
                .addClass("ui-state-highlight");
            setTimeout(function () {
                tips.removeClass("ui-state-highlight", 1500);
            }, 500);
        }

        function checkLength(o) {
            if (o.val().length == 0) {
                o.addClass("ui-state-error");
                updateTips("Please insert allowance type!");
                return false;
            } else {
                return true;
            }
        }

        function checkRegexp(o, regexp, n) {
            if (!(regexp.test(o.val()))) {
                o.addClass("ui-state-error");
                updateTips(n);
                return false;
            } else {
                return true;
            }
        }

        function addUser() {
            var valid = true;
            allFields.removeClass("ui-state-error");

            valid = valid && checkLength(name);
            valid = valid && checkRegexp(name, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for allowance type.");

            if (valid) {
                const createAllowance = {
                    "name": document.getElementById('name').value,
                    "_token": "{{ csrf_token() }}"
                };
                
                $.ajax({
                    url: "{{ URL::to('createAllowance') }}",
                    type: "POST",
                    async: false,
                    data: createAllowance,
                    success: function (s) {
                        $('#allowance').append($('<option>', {
                            value: s,
                            text: name.val(),
                            selected: true
                        }));
                    }
                });

                dialog.dialog("close");
            }
            return valid;
        }

        dialog = $("#dialog-form").dialog({
            autoOpen: false,
            height: 250,
            width: 350,
            modal: true,
            buttons: {
                "Create": addUser,
                Cancel: function () {
                    dialog.dialog("close");
                }
            },
            close: function () {
                form[0].reset();
                allFields.removeClass("ui-state-error");
            }
        });

        form = dialog.find("form").on("submit", function (event) {
            event.preventDefault();
            addUser();
        });

        $('#allowance').change(function () {
            if ($(this).val() == "cnew") {
                dialog.dialog("open");
            }
        });
    });
</script>
@stop