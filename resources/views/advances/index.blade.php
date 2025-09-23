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
                                            <h5 class="mb-0"><i class="feather icon-calendar mr-2 text-primary"></i>Payroll Period</h5>
                                            <small class="text-muted">Select period for advance payroll preview</small>
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

                                    <div id="dialog-form" title="Create New Account" style="display: none;">
                                        <p class="validateTips">Please fill all required fields.</p>
                                        <form>
                                            <div class="form-group">
                                                <label for="category">Account Category <span class="text-danger">*</span></label>
                                                <select class="form-control" name="category" id="category">
                                                    <option value="">Select Category</option>
                                                    <option value="ASSET">Asset (1000)</option>
                                                    <option value="INCOME">Income (2000)</option>
                                                    <option value="EXPENSE">Expense (3000)</option>
                                                    <option value="EQUITY">Equity (4000)</option>
                                                    <option value="LIABILITY">Liability (5000)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" id="name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="code">GL Code <span class="text-danger">*</span></label>
                                                <input type="text" name="code" id="code" class="form-control">
                                            </div>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{ URL::to('advance/preview')}}" accept-charset="UTF-8" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="period" class="form-label">Period <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                        </div>
                                                        <input required class="form-control datepicker2" placeholder="Select period" 
                                                               type="text" name="period" id="period" value="{{ old('period') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="account" class="form-label">Select Account <span class="text-danger">*</span></label>
                                                    <select name="account" id="account" class="form-control" required>
                                                        <option value="">Select Account</option>
                                                        <option value="cnew">Create New Account</option>
                                                        @foreach($accounts as $account)
                                                            <option value="{{ $account->id }}"> 
                                                                {{ $account->code.' - '.$account->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="feather icon-check-circle mr-1"></i> Select
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

    <link rel="stylesheet" href="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.css') }}">
    <script type="text/javascript" src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.js') }}"></script>
    <script src="{{ asset('datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <style>
        .card-header {
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
        
        #dialog-form {
            padding: 20px;
        }
        
        .ui-dialog {
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .ui-dialog-titlebar {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
            font-weight: 600;
        }
    </style>

    <script type="text/javascript">
        $(function () {
            $('.datepicker2').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
        });

        $(function () {
            var dialog, form,
                name = $("#name"),
                code = $("#code"),
                category = $("#category"),
                allFields = $([]).add(name).add(code).add(category),
                tips = $(".validateTips");

            function updateTips(t) {
                tips.text(t).addClass("ui-state-highlight");
                setTimeout(function () {
                    tips.removeClass("ui-state-highlight", 1500);
                }, 500);
            }

            function checkLength(o, m) {
                if (o.val().length == 0 || o.val() == '') {
                    o.addClass("ui-state-error");
                    updateTips(m);
                    return false;
                } else {
                    return true;
                }
            }

            function addUser() {
                var valid = true;
                allFields.removeClass("ui-state-error");

                valid = valid && checkLength(category, "Please select account category!");
                valid = valid && checkLength(name, "Please insert account name!");
                valid = valid && checkLength(code, "Please insert account code!");

                if (valid) {
                    const advance = {
                        "name": document.getElementById('name').value,
                        "code": document.getElementById('code').value,
                        "category": document.getElementById('category').value,
                        "_token": "{{ csrf_token() }}"
                    };
                    
                    $.ajax({
                        url: "{{ URL::to('createAccount') }}",
                        type: "POST",
                        async: false,
                        data: advance,
                        success: function (s) {
                            $('#account').append($('<option>', {
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
                height: 390,
                width: 400,
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

            form = dialog.find("form");
            $('#account').change(function () {
                if ($(this).val() == "cnew") {
                    dialog.dialog("open");
                }
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