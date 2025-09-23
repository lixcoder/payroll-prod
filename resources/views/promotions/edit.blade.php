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
                                                <i class="feather icon-trending-up mr-2 text-primary"></i>
                                                Update Promotion/Demotion
                                            </h5>
                                            <small class="text-muted">
                                                Modify employee promotion or demotion record
                                            </small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('promotions') }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i>
                                                Back to List
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

                                    @if (Session::has('success_message'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i>
                                            {{ Session::get('success_message') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ URL::to('promotions/update/'.$promotion->id) }}" accept-charset="UTF-8" id="promotionForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="employee" class="form-label">
                                                        Employee <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-user text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <select name="employee" id="employee" class="form-control select2" required>
                                                            <option value="">Select Employee</option>
                                                            @foreach($employees as $employee)
                                                                <option value="{{ $employee->id }}" 
                                                                    {{ $promotion->employee_id == $employee->id ? 'selected="selected"' : '' }}>
                                                                    {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="type" class="form-label">
                                                        Type <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-arrow-up text-info"></i>
                                                            </span>
                                                        </div>
                                                        <select name="type" id="type" class="form-control" required>
                                                            <option value="">Select Type</option>
                                                            <option value="Promotion" 
                                                                {{ $promotion->type == 'Promotion' ? 'selected="selected"' : '' }}>
                                                                Promotion
                                                            </option>
                                                            <option value="Demotion" 
                                                                {{ $promotion->type == 'Demotion' ? 'selected="selected"' : '' }}>
                                                                Demotion
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date" class="form-label">
                                                        Date <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-calendar text-info"></i>
                                                            </span>
                                                        </div>
                                                        <input class="form-control" 
                                                               type="date" 
                                                               name="date" 
                                                               id="date"
                                                               value="{{ $promotion->promotion_date }}"
                                                               required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="reason" class="form-label">
                                                        Reason <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">
                                                                <i class="feather icon-file-text text-info"></i>
                                                            </span>
                                                        </div>
                                                        <textarea class="form-control" 
                                                                  name="reason" 
                                                                  id="reason" 
                                                                  rows="4" 
                                                                  placeholder="Enter reason for promotion/demotion"
                                                                  required>{{ $promotion->reason }}</textarea>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Provide detailed explanation for this action
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions mt-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather icon-check-circle mr-1"></i>
                                                Update Record
                                            </button>
                                            <a href="{{ URL::to('promotions') }}" class="btn btn-outline-secondary">
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
        
        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3 0%, #007bff 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .select2 {
            width: 100% !important;
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for employee dropdown
            $('.select2').select2({
                placeholder: "Select Employee",
                allowClear: true
            });

            // Form validation
            $('#promotionForm').validate({
                rules: {
                    employee: {
                        required: true
                    },
                    type: {
                        required: true
                    },
                    date: {
                        required: true,
                        date: true
                    },
                    reason: {
                        required: true,
                        minlength: 10,
                        maxlength: 500
                    }
                },
                messages: {
                    employee: {
                        required: "Please select an employee"
                    },
                    type: {
                        required: "Please select promotion/demotion type"
                    },
                    date: {
                        required: "Please select a date",
                        date: "Please enter a valid date"
                    },
                    reason: {
                        required: "Please provide a reason",
                        minlength: "Reason must be at least 10 characters long",
                        maxlength: "Reason cannot exceed 500 characters"
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

            // Change icon based on selection
            $('#type').on('change', function() {
                const icon = $(this).closest('.form-group').find('.input-group-text i');
                if ($(this).val() === 'Promotion') {
                    icon.removeClass('icon-arrow-down text-danger').addClass('icon-arrow-up text-success');
                } else if ($(this).val() === 'Demotion') {
                    icon.removeClass('icon-arrow-up text-success').addClass('icon-arrow-down text-danger');
                } else {
                    icon.removeClass('icon-arrow-up icon-arrow-down text-success text-danger').addClass('icon-arrow-up text-info');
                }
            });

            // Initialize icon based on current value
            if ($('#type').val() === 'Promotion') {
                $('#type').closest('.form-group').find('.input-group-text i').removeClass('icon-arrow-up text-info').addClass('icon-arrow-up text-success');
            } else if ($('#type').val() === 'Demotion') {
                $('#type').closest('.form-group').find('.input-group-text i').removeClass('icon-arrow-up text-info').addClass('icon-arrow-down text-danger');
            }

            // Fade out alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@stop