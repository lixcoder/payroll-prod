@extends('layouts.main_hr')
@section('xara_cbs')
    <?php function asMoney($value) {
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
                                            <h5 class="mb-0"><i class="feather icon-calculator mr-2 text-primary"></i>Payroll Calculator</h5>
                                            <small class="text-muted">Calculate gross to net and net to gross salaries</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-x-circle mr-2"></i>
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <ul class="nav nav-tabs nav-fill mb-4" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="grosstonet-tab" data-toggle="tab" href="#grosstonet" role="tab">
                                                <i class="feather icon-arrow-down mr-1"></i> Gross to Net
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="nettogross-tab" data-toggle="tab" href="#nettogross" role="tab">
                                                <i class="feather icon-arrow-up mr-1"></i> Net to Gross
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="grosstonet" role="tabpanel">
                                            <form id="grossform" class="needs-validation" novalidate>
                                                <?php
                                                $a = str_replace(',', '', request()->input('gross'));
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="gross" class="form-label">Gross Pay <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">{{ $currency->shortname }}</span>
                                                                </div>
                                                                <input class="form-control" placeholder="Enter gross salary" 
                                                                       type="text" name="gross" id="gross" 
                                                                       value="{{ !empty($a) ? asMoney($a) : '0.00' }}" required>
                                                                <div class="invalid-feedback">Please enter a valid gross salary</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Deductions</label>
                                                            <div class="card bg-light">
                                                                <div class="card-body p-3">
                                                                    <div class="d-flex justify-content-between mb-2">
                                                                        <span>PAYE Tax:</span>
                                                                        <span class="font-weight-bold text-danger" id="paye-display">0.00</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between mb-2">
                                                                        <span>NSSF:</span>
                                                                        <span class="font-weight-bold text-danger" id="nssf-display">0.00</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between mb-2">
                                                                        <span>SHIF:</span>
                                                                        <span class="font-weight-bold text-danger" id="shif-display">0.00</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between">
                                                                        <span>Housing Levy:</span>
                                                                        <span class="font-weight-bold text-danger" id="housing_levy-display">0.00</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="net" class="form-label">Net Pay</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">{{ $currency->shortname }}</span>
                                                                </div>
                                                                <input class="form-control font-weight-bold text-success" 
                                                                       readonly type="text" name="net" id="net" value="0.00">
                                                            </div>
                                                        </div>
                                                        <div class="mt-4 text-center">
                                                            <div class="summary-card bg-gradient-primary text-white p-3 rounded">
                                                                <h6 class="mb-1">Take Home</h6>
                                                                <h3 class="mb-0" id="net-summary">0.00</h3>
                                                                <small>{{ $currency->shortname }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-actions form-group">
                                                    <button type="submit" class="btn btn-primary btn-lg">
                                                        <i class="feather icon-calculator mr-1"></i> Calculate Net Pay
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="nettogross" role="tabpanel">
                                            <form id="netform" class="needs-validation" novalidate>
                                                <?php
                                                $b = str_replace(',', '', request()->input('net1'));
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="net1" class="form-label">Net Pay <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">{{ $currency->shortname }}</span>
                                                                </div>
                                                                <input class="form-control" placeholder="Enter desired net salary" 
                                                                       type="text" name="net1" id="net1" 
                                                                       value="{{ !empty($b) ? asMoney($b) : '0.00' }}" required>
                                                                <div class="invalid-feedback">Please enter a valid net salary</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Required Gross</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">{{ $currency->shortname }}</span>
                                                                </div>
                                                                <input class="form-control font-weight-bold text-primary" 
                                                                       readonly type="text" name="gross1" id="gross1" value="0.00">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Deductions</label>
                                                            <div class="card bg-light">
                                                                <div class="card-body p-3">
                                                                    <div class="d-flex justify-content-between mb-2">
                                                                        <span>PAYE Tax:</span>
                                                                        <span class="font-weight-bold text-danger" id="paye1-display">0.00</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between mb-2">
                                                                        <span>NSSF:</span>
                                                                        <span class="font-weight-bold text-danger" id="nssf1-display">0.00</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between mb-2">
                                                                        <span>SHIF:</span>
                                                                        <span class="font-weight-bold text-danger" id="shif1-display">0.00</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between">
                                                                        <span>Housing Levy:</span>
                                                                        <span class="font-weight-bold text-danger" id="housing_levy1-display">0.00</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-actions form-group">
                                                    <button type="submit" class="btn btn-primary btn-lg">
                                                        <i class="feather icon-calculator mr-1"></i> Calculate Gross Pay
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
        </div>
    </div>

    <script src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
    <style>
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .nav-tabs .nav-link {
            border: none;
            border-bottom: 3px solid transparent;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 20px;
        }
        
        .nav-tabs .nav-link.active {
            border-bottom-color: #4361ee;
            color: #4361ee;
            background: transparent;
        }
        
        .nav-tabs .nav-link:hover {
            border-bottom-color: #dee2e6;
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
            min-width: 60px;
            justify-content: center;
        }
        
        .summary-card {
            background: linear-gradient(135deg, #4361ee 0%, #3a56d4 100%);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }
        
        .btn-lg {
            padding: 12px 24px;
            font-weight: 500;
            border-radius: 8px;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 16px 20px;
        }
    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            // Format number input as user types
            function formatNumberInput(input) {
                let value = input.val().replace(/[,\s]/g, '').trim();
                
                if (/^\d+(\.\d{0,2})?$/.test(value) && parseFloat(value) > 0) {
                    input.val(parseFloat(value).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                } else if (value === '' || value === '0') {
                    input.val('0.00');
                } else {
                    let previousValue = input.data('previous-value') || '0.00';
                    input.val(previousValue);
                }
                
                input.data('previous-value', input.val());
            }

            // Validate input before processing
            function validateNumberInput(inputValue, fieldName) {
                let cleanValue = inputValue.replace(/[,\s]/g, '').trim();
                
                if (!/^\d+(\.\d{0,2})?$/.test(cleanValue) || parseFloat(cleanValue) <= 0) {
                    return { valid: false, message: `Please enter a valid ${fieldName}` };
                }
                
                return { valid: true, value: parseFloat(cleanValue) };
            }

            // Format inputs on blur
            $('#gross, #net1').on('blur', function() {
                formatNumberInput($(this));
            });

            // Store initial values
            $('#gross').data('previous-value', $('#gross').val());
            $('#net1').data('previous-value', $('#net1').val());

            // Gross to Net calculation
            $('#grossform').on('submit', function (event) {
                event.preventDefault();
                
                if (!this.checkValidity()) {
                    event.stopPropagation();
                    this.classList.add('was-validated');
                    return;
                }

                let grossValue = $('#gross').val();
                let validation = validateNumberInput(grossValue, 'gross salary');
                
                if (!validation.valid) {
                    alert(validation.message);
                    return;
                }

                let submitBtn = $(this).find('button[type="submit"]');
                let originalText = submitBtn.html();
                submitBtn.html('<i class="feather icon-loader spin mr-1"></i> Calculating...').prop('disabled', true);

                $.ajax({
                    url: "{{ route('payroll.shownet') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'formdata': $(this).serialize(),
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }
                        
                        // Update all fields
                        $('#gross').val(data.gross);
                        $('#paye-display').text(data.paye);
                        $('#nssf-display').text(data.nssf);
                        $('#shif-display').text(data.shif);
                        $('#housing_levy-display').text(data.housing_levy || '0.00');
                        $('#net').val(data.net);
                        $('#net-summary').text(data.net);
                        
                        $('#gross').data('previous-value', data.gross);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert('Error: ' + xhr.responseJSON.error);
                        } else {
                            alert('An error occurred while calculating. Please try again.');
                        }
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // Net to Gross calculation
            $('#netform').on('submit', function (event) {
                event.preventDefault();
                
                if (!this.checkValidity()) {
                    event.stopPropagation();
                    this.classList.add('was-validated');
                    return;
                }

                let netValue = $('#net1').val();
                let validation = validateNumberInput(netValue, 'net salary');
                
                if (!validation.valid) {
                    alert(validation.message);
                    return;
                }

                let submitBtn = $(this).find('button[type="submit"]');
                let originalText = submitBtn.html();
                submitBtn.html('<i class="feather icon-loader spin mr-1"></i> Calculating...').prop('disabled', true);

                $.ajax({
                    url: "{{ route('payroll.showgross') }}",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'formdata': $(this).serialize(),
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }
                                        
                        $('#gross1').val(data.gross1);
                        $('#paye1-display').text(data.paye1);
                        $('#nssf1-display').text(data.nssf1);
                        $('#shif1-display').text(data.shif);
                        $('#housing_levy1-display').text(data.housing_levy1 || '0.00');
                        $('#net1').val(data.netv);
                        
                        $('#net1').data('previous-value', data.netv);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert('Error: ' + xhr.responseJSON.error);
                        } else {
                            alert('An error occurred while calculating. Please try again.');
                        }
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // Switch tabs and maintain form validation state
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $('.needs-validation').removeClass('was-validated');
            });
        });
    </script>
@endsection