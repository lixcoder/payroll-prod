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
                                                <i class="feather icon-edit-2 mr-2 text-warning"></i>
                                                Update Shif Rate
                                            </h5>
                                            <small class="text-muted">
                                                Modify Shif contribution rate
                                            </small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('nhif') }}" class="btn btn-outline-secondary btn-sm">
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

                                    <form method="POST" action="{{ URL::to('nhif/update/'.$nrate->id) }}" accept-charset="UTF-8" id="shifForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rate" class="form-label">
                                                        Rate <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-dollar-sign text-danger"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter rate amount" 
                                                               type="number" 
                                                               name="rate"
                                                               id="rate"
                                                               step="0.01"
                                                               min="0"
                                                               value="{{ $nrate->rate }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Shif contribution amount
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="minimum_amount" class="form-label">
                                                        Minimum Amount <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-arrow-up text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               placeholder="Enter minimum amount" 
                                                               type="number" 
                                                               name="minimum_amount"
                                                               id="minimum_amount"
                                                               step="0.01"
                                                               min="0"
                                                               value="{{ $nrate->minimum_amount }}"
                                                               required>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Minimum salary amount for this rate bracket
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions mt-4">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="feather icon-check-circle mr-1"></i>
                                                Update Shif Rate
                                            </button>
                                            <a href="{{ URL::to('nhif') }}" class="btn btn-outline-secondary">
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
            $('#shifForm').validate({
                rules: {
                    rate: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    minimum_amount: {
                        required: true,
                        number: true,
                        min: 0
                    }
                },
                messages: {
                    rate: {
                        required: "Please enter Shif rate",
                        number: "Please enter a valid amount",
                        min: "Rate cannot be negative"
                    },
                    minimum_amount: {
                        required: "Please enter minimum amount",
                        number: "Please enter a valid amount",
                        min: "Minimum amount cannot be negative"
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