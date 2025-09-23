@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.bearcrumbs')
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
                                                <i class="feather icon-edit-2 mr-2 text-warning"></i>
                                                Update Housing Levy
                                            </h5>
                                            <small class="text-muted">
                                                Modify housing levy contribution rates
                                            </small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('housinglevy') }}" class="btn btn-outline-secondary btn-sm">
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

                                    <form action="{{ route('housinglevy.update', $hrate->id) }}" method="POST" id="housingLevyForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="employee_rate" class="form-label">
                                                        Employee Contribution (%) <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-user text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <input type="number" 
                                                               step="0.01" 
                                                               name="employee_rate" 
                                                               id="employee_rate" 
                                                               class="form-control" 
                                                               placeholder="Enter employee percentage"
                                                               value="{{ old('employee_rate', $hrate->employee_rate) }}" 
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Employee contribution percentage for housing levy
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="employer_rate" class="form-label">
                                                        Employer Contribution (%) <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-briefcase text-success"></i>
                                                            </span>
                                                        </div>
                                                        <input type="number" 
                                                               step="0.01" 
                                                               name="employer_rate" 
                                                               id="employer_rate" 
                                                               class="form-control" 
                                                               placeholder="Enter employer percentage"
                                                               value="{{ old('employer_rate', $hrate->employer_rate) }}" 
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Employer contribution percentage for housing levy
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions mt-4">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="feather icon-check-circle mr-1"></i>
                                                Update Housing Levy
                                            </button>
                                            <a href="{{ URL::to('housinglevy') }}" class="btn btn-outline-secondary">
                                                <i class="feather icon-x-circle mr-1"></i>
                                                Cancel
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
        
        .btn-warning {
            background: linear-gradient(135deg, #f5a623 0%, #f7b84c 100%);
            border: none;
            color: #fff;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #f7b84c 0%, #f5a623 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            color: #fff;
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
            $('#housingLevyForm').validate({
                rules: {
                    employee_rate: {
                        required: true,
                        number: true,
                        min: 0,
                        max: 100
                    },
                    employer_rate: {
                        required: true,
                        number: true,
                        min: 0,
                        max: 100
                    }
                },
                messages: {
                    employee_rate: {
                        required: "Please enter employee contribution rate",
                        number: "Please enter a valid percentage",
                        min: "Rate cannot be negative",
                        max: "Rate cannot exceed 100%"
                    },
                    employer_rate: {
                        required: "Please enter employer contribution rate",
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
            
            // Fade out alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@stop