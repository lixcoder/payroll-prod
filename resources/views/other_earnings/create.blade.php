@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="feather icon-plus-circle mr-2"></i>New Employee Earning</h5>
                                    <div class="card-header-right">
                                        <a href="{{ URL::to('other_earnings') }}" class="btn btn-light btn-sm">
                                            <i class="feather icon-arrow-left mr-1"></i> Back to List
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong>Please fix the following errors:</strong>
                                            <ul class="mb-0 mt-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <!-- Earning Type Creation Modal -->
                                    <div id="earning-type-modal" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title"><i class="feather icon-plus mr-2"></i>Create New Earning Type</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-info">
                                                        <i class="feather icon-info mr-2"></i>Enter a name for the new earning type
                                                    </div>
                                                    <form id="earning-type-form">
                                                        <div class="form-group">
                                                            <label for="earning-name" class="font-weight-bold">Earning Type Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-lg" id="earning-name" name="name" required placeholder="Enter earning type name">
                                                            <div class="invalid-feedback" id="earning-name-error"></div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-primary" id="create-earning-type">
                                                        <i class="feather icon-check mr-1"></i> Create
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ URL::to('other_earnings') }}" class="professional-form" id="earning-form">
                                        @csrf
                                        
                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-user mr-2 text-primary"></i>Employee Information
                                            </h6>
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="employee" class="font-weight-bold">Employee <span class="text-danger">*</span></label>
                                                            <select name="employee" id="employee" class="form-control select2 professional-select" required>
                                                                <option value="">Select Employee</option>
                                                                @foreach($employees as $employee)
                                                                    <option value="{{ $employee->id }}" {{ old('employee') == $employee->id ? 'selected' : '' }}>
                                                                        {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="earning" class="font-weight-bold">Earning Type <span class="text-danger">*</span></label>
                                                            <select name="earning" id="earning" class="form-control select2 professional-select" required>
                                                                <option value="">Select Earning Type</option>
                                                                <option value="cnew" {{ old('earning') == 'cnew' ? 'selected' : '' }}>
                                                                    <i class="feather icon-plus mr-1"></i> Create New Earning Type
                                                                </option>
                                                                @foreach($earnings as $earning)
                                                                    <option value="{{ $earning->id }}" {{ old('earning') == $earning->id ? 'selected' : '' }}>
                                                                        {{ $earning->earning_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="narrative" class="font-weight-bold">Earning Narrative</label>
                                                    <textarea class="form-control" name="narrative" id="narrative" rows="2" placeholder="Describe the purpose of this earning">{{ old('narrative') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-settings mr-2 text-primary"></i>Earning Details
                                            </h6>
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="formular" class="font-weight-bold">Payment Type <span class="text-danger">*</span></label>
                                                            <select name="formular" id="formular" class="form-control professional-select" required>
                                                                <option value="">Select Payment Type</option>
                                                                <option value="One Time" {{ old('formular') == 'One Time' ? 'selected' : '' }}>One Time Payment</option>
                                                                <option value="Recurring" {{ old('formular') == 'Recurring' ? 'selected' : '' }}>Recurring Payment</option>
                                                                <option value="Instalments" {{ old('formular') == 'Instalments' ? 'selected' : '' }}>Installment Payment</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4 instalment-field" style="display: none;">
                                                        <div class="form-group">
                                                            <label for="instalments" class="font-weight-bold">Number of Installments</label>
                                                            <input type="number" class="form-control" name="instalments" id="instalments" 
                                                                   min="1" value="{{ old('instalments') }}" placeholder="Enter number of installments">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="ddate" class="font-weight-bold">Earning Date <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control datepicker professional-input" name="ddate" id="ddate" 
                                                                       value="{{ old('ddate') }}" placeholder="Select date" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text bg-primary text-white"><i class="feather icon-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="amount" class="font-weight-bold">Amount <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                @if(isset($currency) && $currency->shortname)
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text bg-light border-right-0">{{ $currency->shortname }}</span>
                                                                    </div>
                                                                @endif
                                                                <input type="text" class="form-control amount-input professional-input" name="amount" id="amount" 
                                                                       value="{{ old('amount') }}" placeholder="0.00" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6 total-field" style="display: none;">
                                                        <div class="form-group">
                                                            <label for="balance" class="font-weight-bold">Total Amount</label>
                                                            <div class="input-group">
                                                                @if(isset($currency) && $currency->shortname)
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text bg-light border-right-0">{{ $currency->shortname }}</span>
                                                                    </div>
                                                                @endif
                                                                <input type="text" class="form-control professional-input" name="balance" id="balance" 
                                                                       value="{{ old('balance') }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-right p-3 border-top">
                                            <button type="reset" class="btn btn-outline-secondary mr-2">
                                                <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather icon-save mr-1"></i> Create Employee Earning
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        .professional-form {
            background: #fff;
        }
        
        .card-header {
            border-radius: 4px 4px 0 0;
        }
        
        .form-section {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #fff;
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
            border-radius: 6px 6px 0 0;
        }
        
        .professional-select {
            border: 1px solid #dce4ec;
            border-radius: 4px;
            transition: all 0.3s ease;
            height: 44px;
        }
        
        .professional-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .professional-input {
            border: 1px solid #dce4ec;
            border-radius: 4px;
            transition: all 0.3s ease;
            height: 44px;
        }
        
        .professional-input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .select2-container--default .select2-selection--single {
            height: 44px;
            border: 1px solid #dce4ec;
            border-radius: 4px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px;
            padding-left: 15px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #dce4ec;
            color: #2c3e50;
        }
        
        .amount-input {
            text-align: right;
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .btn {
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .alert {
            border: none;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .modal-header {
            border-radius: 6px 6px 0 0;
        }
        
        .modal-content {
            border: none;
            border-radius: 6px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .datepicker {
            z-index: 1000 !important;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 with professional styling
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '100%'
            });
            
            // Initialize datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                endDate: new Date(),
                orientation: "bottom auto"
            });
            
            // Initialize amount input mask
            $('#amount').inputmask('decimal', {
                rightAlign: false,
                digits: 2,
                placeholder: '0.00',
                radixPoint: ".",
                groupSeparator: ","
            });
            
            // Handle earning type selection
            $('#earning').on('change', function() {
                if ($(this).val() === 'cnew') {
                    $('#earning-type-modal').modal('show');
                    setTimeout(() => {
                        $(this).val('').trigger('change');
                    }, 300);
                }
            });
            
            // Handle formula selection
            $('#formular').on('change', function() {
                if ($(this).val() === 'Instalments') {
                    $('.instalment-field, .total-field').slideDown(300);
                    calculateTotal();
                } else {
                    $('.instalment-field, .total-field').slideUp(300);
                    $('#balance').val('');
                }
            });
            
            // Calculate total when amount or installments change
            $('#amount, #instalments').on('input', function() {
                calculateTotal();
            });
            
            // Create new earning type
            $('#create-earning-type').on('click', function() {
                const name = $('#earning-name').val().trim();
                const errorDiv = $('#earning-name-error');
                
                if (!name) {
                    errorDiv.text('Earning type name is required');
                    $('#earning-name').addClass('is-invalid');
                    return;
                }
                
                $('#earning-name').removeClass('is-invalid');
                
                // AJAX request to create new earning type
                $.ajax({
                    url: "{{ URL::to('createEarning') }}",
                    type: "POST",
                    data: {
                        name: name,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $('#create-earning-type').prop('disabled', true).html('<i class="feather icon-loader mr-1"></i> Creating...');
                    },
                    success: function(response) {
                        // Add new option to select
                        const newOption = new Option(name, response, true, true);
                        $('#earning').append(newOption).trigger('change');
                        
                        // Close modal and reset form
                        $('#earning-type-modal').modal('hide');
                        $('#earning-name').val('');
                        
                        // Show success message
                        showNotification('Earning type created successfully!', 'success');
                    },
                    error: function(xhr) {
                        errorDiv.text('Error creating earning type: ' + (xhr.responseJSON?.message || 'Unknown error'));
                        $('#earning-name').addClass('is-invalid');
                    },
                    complete: function() {
                        $('#create-earning-type').prop('disabled', false).html('<i class="feather icon-check mr-1"></i> Create');
                    }
                });
            });
            
            // Form validation
            $('#earning-form').on('submit', function(e) {
                let isValid = true;
                
                // Basic validation
                $('#employee, #earning, #formular, #amount, #ddate').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                    
                    showNotification('Please fill all required fields', 'error');
                }
            });
            
            // Remove validation classes on input
            $('input, select').on('input change', function() {
                $(this).removeClass('is-invalid');
            });
            
            function calculateTotal() {
                const instalments = parseInt($('#instalments').val()) || 0;
                const amount = parseFloat($('#amount').val().replace(/,/g, '')) || 0;
                
                if (instalments > 0 && amount > 0) {
                    const total = instalments * amount;
                    $('#balance').val(total.toLocaleString('en-US', {minimumFractionDigits: 2}));
                } else {
                    $('#balance').val('');
                }
            }
            
            function showNotification(message, type) {
                // Create notification element
                const notification = $('<div class="alert alert-' + type + ' alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
                    '<button type="button" class="close" data-dismiss="alert">×</button>' +
                    '<strong>' + message + '</strong>' +
                    '</div>');
                
                // Append to body and auto remove after 5 seconds
                $('body').append(notification);
                setTimeout(function() {
                    notification.alert('close');
                }, 5000);
            }
            
            // Trigger formular change on page load in case of old values
            $('#formular').trigger('change');
        });
    </script>
@stop