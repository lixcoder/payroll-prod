@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <!-- Card Header -->
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0">
                                                <i class="feather icon-plus-circle mr-2 text-success"></i>
                                                Create New NSSF Rate
                                            </h5>
                                            <small class="text-muted">
                                                Add a new National Social Security Fund contribution rate
                                            </small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('nssf') }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i>
                                                Back to Rates
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Error Messages -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-alert-triangle mr-2"></i>
                                            <strong>Please fix the following errors:</strong>
                                            <ul class="mb-0 mt-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ URL::to('nssf') }}" accept-charset="UTF-8" id="nssfForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lower_earnings_limit" class="form-label">
                                                        Lower Earnings Limit <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-arrow-down text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter lower limit" 
                                                               type="number" 
                                                               name="lower_earnings_limit"
                                                               id="lower_earnings_limit"
                                                               step="0.01"
                                                               min="0"
                                                               value="{{ old('lower_earnings_limit') }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Minimum earnings amount for this bracket
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="upper_earnings_limit" class="form-label">
                                                        Upper Earnings Limit <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-arrow-up text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter upper limit" 
                                                               type="number" 
                                                               name="upper_earnings_limit"
                                                               id="upper_earnings_limit"
                                                               step="0.01"
                                                               min="0"
                                                               value="{{ old('upper_earnings_limit') }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Maximum earnings amount for this bracket
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rate_tier1" class="form-label">
                                                        Tier 1 Rate (%) <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-percent text-success"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter tier 1 rate" 
                                                               type="number" 
                                                               name="rate_tier1"
                                                               id="rate_tier1"
                                                               step="0.01"
                                                               min="0"
                                                               max="100"
                                                               value="{{ old('rate_tier1') }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Contribution rate for tier 1 (employee)
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rate_tier2" class="form-label">
                                                        Tier 2 Rate (%) <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-percent text-warning"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter tier 2 rate" 
                                                               type="number" 
                                                               name="rate_tier2"
                                                               id="rate_tier2"
                                                               step="0.01"
                                                               min="0"
                                                               max="100"
                                                               value="{{ old('rate_tier2') }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Contribution rate for tier 2 (employer)
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions mt-4">
                                            <button type="submit" class="btn btn-success">
                                                <i class="feather icon-save mr-1"></i>
                                                Create NSSF Rate
                                            </button>
                                            <button type="reset" class="btn btn-outline-secondary">
                                                <i class="feather icon-refresh-cw mr-1"></i>
                                                Reset
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

    <style>
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }
        
        .form-control:focus + .input-group-prepend .input-group-text {
            border-color: #80bdff;
            background-color: #e9ecef;
        }
        
        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
            padding: 0.5rem 1.5rem;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .card-header-right {
                margin-top: 1rem;
                width: 100%;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .form-actions {
                display: flex;
                flex-direction: column;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            // Form validation
            $('#nssfForm').validate({
                rules: {
                    lower_earnings_limit: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    upper_earnings_limit: {
                        required: true,
                        number: true,
                        min: function() {
                            return parseFloat($('#lower_earnings_limit').val()) || 0;
                        }
                    },
                    rate_tier1: {
                        required: true,
                        number: true,
                        min: 0,
                        max: 100
                    },
                    rate_tier2: {
                        required: true,
                        number: true,
                        min: 0,
                        max: 100
                    }
                },
                messages: {
                    lower_earnings_limit: {
                        required: "Please enter lower earnings limit",
                        number: "Please enter a valid number",
                        min: "Lower limit cannot be negative"
                    },
                    upper_earnings_limit: {
                        required: "Please enter upper earnings limit",
                        number: "Please enter a valid number",
                        min: "Upper limit must be greater than lower limit"
                    },
                    rate_tier1: {
                        required: "Please enter tier 1 rate",
                        number: "Please enter a valid percentage",
                        min: "Rate cannot be negative",
                        max: "Rate cannot exceed 100%"
                    },
                    rate_tier2: {
                        required: "Please enter tier 2 rate",
                        number: "Please enter a valid percentage",
                        min: "Rate cannot be negative",
                        max: "Rate cannot exceed 100%"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            
            // Validate upper limit is greater than lower limit
            $('#upper_earnings_limit').on('blur', function() {
                var lower = parseFloat($('#lower_earnings_limit').val());
                var upper = parseFloat($(this).val());
                
                if (upper <= lower) {
                    $(this).addClass('is-invalid');
                    $(this).siblings('.invalid-feedback').remove();
                    $(this).after('<span class="invalid-feedback">Upper limit must be greater than lower limit</span>');
                }
            });
            
            // Fade out alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@endsection