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
                                                Add New PAYE Rate
                                            </h5>
                                            <small class="text-muted">
                                                Create a new Pay As You Earn tax rate bracket
                                            </small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('paye') }}" class="btn btn-outline-secondary btn-sm">
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

                                    <form method="POST" action="{{ url('paye') }}" accept-charset="UTF-8" id="payeForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="income_from" class="form-label">
                                                        Income From (KES) <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-arrow-down text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter minimum income" 
                                                               type="number" 
                                                               name="income_from"
                                                               id="income_from"
                                                               step="0.01"
                                                               min="0"
                                                               value="{{ old('income_from') }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Lower limit of income bracket
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="income_to" class="form-label">
                                                        Income To (KES) <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-arrow-up text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter maximum income" 
                                                               type="number" 
                                                               name="income_to"
                                                               id="income_to"
                                                               step="0.01"
                                                               min="0"
                                                               value="{{ old('income_to') }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Upper limit of income bracket
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="percentage" class="form-label">
                                                        Tax Rate (%) <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-percent text-info"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter tax percentage" 
                                                               type="number" 
                                                               name="percentage"
                                                               id="percentage"
                                                               step="0.01"
                                                               min="0"
                                                               max="100"
                                                               value="{{ old('percentage') }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Tax rate percentage for this bracket
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions mt-4">
                                            <button type="submit" class="btn btn-success">
                                                <i class="feather icon-save mr-1"></i>
                                                Create PAYE Rate
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
            $('#payeForm').validate({
                rules: {
                    income_from: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    income_to: {
                        required: true,
                        number: true,
                        min: function() {
                            return parseFloat($('#income_from').val()) || 0;
                        }
                    },
                    percentage: {
                        required: true,
                        number: true,
                        min: 0,
                        max: 100
                    }
                },
                messages: {
                    income_from: {
                        required: "Please enter income from amount",
                        number: "Please enter a valid amount",
                        min: "Income cannot be negative"
                    },
                    income_to: {
                        required: "Please enter income to amount",
                        number: "Please enter a valid amount",
                        min: "Upper limit must be greater than lower limit"
                    },
                    percentage: {
                        required: "Please enter tax percentage",
                        number: "Please enter a valid percentage",
                        min: "Percentage cannot be negative",
                        max: "Percentage cannot exceed 100%"
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
            
            // Validate income_to is greater than income_from
            $('#income_to').on('blur', function() {
                var from = parseFloat($('#income_from').val());
                var to = parseFloat($(this).val());
                
                if (to <= from) {
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