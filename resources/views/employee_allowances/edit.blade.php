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
                                            <h5 class="mb-0"><i class="feather icon-edit-2 mr-2 text-primary"></i>Update Employee Allowance</h5>
                                            <small class="text-muted">Modify employee allowance details</small>
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

                                    <div id="dialog-form" title="Create new allowance type" style="display: none;">
                                        <p class="validateTips">Please insert Allowance Type.</p>
                                        <form>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label for="name">Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" value="" class="form-control" required>
                                                </div>
                                                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                                            </fieldset>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{{ URL::to('employee_allowances/update/'.$eallw->id) }}}" accept-charset="UTF-8">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="employee">Employee</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-user"></i></span>
                                                        </div>
                                                        <input class="form-control" type="text" readonly name="employee" id="employee" value="{{ $eallw->employee->first_name.' '.$eallw->employee->last_name }}">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="allowance">Allowance Type <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-gift"></i></span>
                                                        </div>
                                                        <select name="allowance" id="allowance" class="form-control" required>
                                                            <option value="">Select Allowance Type</option>
                                                            <option value="cnew">Create New</option>
                                                            @foreach($allowances as $allowance)
                                                                <option value="{{$allowance->id }}"<?= ($eallw->allowance_id == $allowance->id) ? 'selected="selected"' : ''; ?>> 
                                                                    {{ $allowance->allowance_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="formular">Formular <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-cpu"></i></span>
                                                        </div>
                                                        <select name="formular" id="formular" class="form-control" required>
                                                            <option value="">Select Formular</option>
                                                            <option value="One Time"<?= ($eallw->formular == 'One Time') ? 'selected="selected"' : ''; ?>>One Time</option>
                                                            <option value="Recurring"<?= ($eallw->formular == 'Recurring') ? 'selected="selected"' : ''; ?>>Recurring</option>
                                                            <option value="Instalments"<?= ($eallw->formular == 'Instalments') ? 'selected="selected"' : ''; ?>>Instalments</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6" id="insts" style="display: none;">
                                                <div class="form-group">
                                                    <label for="instalments">Instalments</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-hash"></i></span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter number of instalments" type="number" min="1" name="instalments" id="instalments" value="{{ $eallw->instalments}}" onkeyup="totalB()">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{$currency->shortname}}</span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter amount" type="text" name="amount" id="amount" value="{{ $eallw->allowance_amount}}" onkeyup="totalBalance()" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6" id="bal" style="display: none;">
                                                <div class="form-group">
                                                    <label for="balance">Total</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{$currency->shortname}}</span>
                                                        </div>
                                                        <input class="form-control" readonly type="text" name="balance" id="balance" value="{{ asMoney((double)$eallw->allowance_amount * (double)$eallw->instalments)}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="adate">Allowance Date <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                        </div>
                                                        <input class="form-control allowancedate" readonly placeholder="Select date" type="text" name="adate" id="adate" value="{{ $eallw->allowance_date }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-actions form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather icon-check-circle mr-1"></i> Update Employee Allowance
                                            </button>
                                            <a href="{{ URL::to('employee_allowances') }}" class="btn btn-outline-secondary">
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
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
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
        
        #dialog-form {
            padding: 20px;
        }
        
        .validateTips {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }
    </style>

    <script src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    
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

        $(document).ready(function () {
            // Initialize price format
            $('#amount').priceFormat();
            
            // Show/hide instalments field based on formular selection
            if ($('#formular').val() == "Instalments") {
                $('#insts').show();
                $('#bal').show();
            } else {
                $('#insts').hide();
                $('#bal').hide();
            }

            $('#formular').change(function () {
                if ($(this).val() == "Instalments") {
                    $('#insts').show();
                    $('#bal').show();
                } else {
                    $('#insts').hide();
                    $('#bal').hide();
                }
            });

            // Datepicker initialization
            $('.allowancedate').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '-60y',
                autoclose: true
            });

            // Dialog form for creating new allowance
            var dialog, form, name = $("#name"), allFields = $([]).add(name), tips = $(".validateTips");

            function updateTips(t) {
                tips.text(t).addClass("alert alert-info");
                setTimeout(function() {
                    tips.removeClass("alert alert-info", 1500);
                }, 5000);
            }

            function checkLength(o) {
                if (o.val().length == 0) {
                    o.addClass("is-invalid");
                    updateTips("Please insert allowance type!");
                    return false;
                } else {
                    o.removeClass("is-invalid");
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("is-invalid");

                valid = valid && checkLength(name);

                if (valid) {
                    $.ajax({
                        url: "{{URL::to('createAllowance')}}",
                        type: "POST",
                        async: false,
                        data: {
                            'name': name.val(),
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function (s) {
                            $('#allowance').append($('<option>', {
                                value: s,
                                text: name.val(),
                                selected: true
                            }));
                        },
                        error: function() {
                            updateTips("Error creating allowance. Please try again.");
                        }
                    });
                    dialog.dialog("close");
                }
                return valid;
            }

            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: 250,
                width: 400,
                modal: true,
                buttons: {
                    "Create": addUser,
                    "Cancel": function() {
                        dialog.dialog("close");
                        $('#allowance').val('');
                    }
                },
                close: function() {
                    form[0].reset();
                    allFields.removeClass("is-invalid");
                }
            });

            form = dialog.find("form").on("submit", function(event) {
                event.preventDefault();
                addUser();
            });

            $('#allowance').change(function() {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }
            });
        });
    </script>
@stop