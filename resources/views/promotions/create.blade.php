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
                                            <h5 class="mb-0"><i class="feather icon-user-check mr-2 text-primary"></i>Employee Transfer/Promotion</h5>
                                            <small class="text-muted">Manage employee career movements and organizational transitions</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('promotions') }}" class="btn btn-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i> Back to Transfers
                                            </a>
                                        </div>
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

                                    <form method="POST" action="{{ url('promotions') }}" class="modern-form">
                                        @csrf
                                        
                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-user mr-2 text-primary"></i>Employee Information
                                            </h6>
                                            <div class="p-3">
                                                <div class="form-group">
                                                    <label for="employee" class="font-weight-bold">Employee <span class="text-danger">*</span></label>
                                                    <select name="employee" id="employee" class="form-control select2" required>
                                                        <option value="">Select Employee</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{ $employee->id }}" {{ old('employee') == $employee->id ? 'selected' : '' }}>
                                                                {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="operation" class="font-weight-bold">Operation Type <span class="text-danger">*</span></label>
                                                    <select name="operation" id="operation" class="form-control" required>
                                                        <option value="">Select Operation</option>
                                                        <option value="promote" {{ old('operation') == 'promote' ? 'selected' : '' }}>Promote</option>
                                                        <option value="transfer" {{ old('operation') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section mb-4" id="salary-section">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-dollar-sign mr-2 text-primary"></i>Salary Information
                                            </h6>
                                            <div class="p-3">
                                                <div class="form-group">
                                                    <label for="salary" class="font-weight-bold">Salary <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light">$</span>
                                                        </div>
                                                        <input type="number" name="salary" class="form-control" value="{{ old('salary') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section mb-4 conditional-field" id="transfer-section">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-map-pin mr-2 text-primary"></i>Transfer Details
                                            </h6>
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="stationfrom" class="font-weight-bold">Transfer From <span class="text-danger">*</span></label>
                                                            <select name="stationfrom" id="stationfrom" class="form-control">
                                                                <option value="">Select Station</option>
                                                                @foreach($stations as $station)
                                                                    <option value="{{ $station->id }}" {{ old('stationfrom') == $station->id ? 'selected' : '' }}>
                                                                        {{ $station->station_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="stationto" class="font-weight-bold">Transfer To <span class="text-danger">*</span></label>
                                                            <select name="stationto" id="stationto" class="form-control">
                                                                <option value="">Select Station</option>
                                                                @foreach($stations as $station)
                                                                    <option value="{{ $station->id }}" {{ old('stationto') == $station->id ? 'selected' : '' }}>
                                                                        {{ $station->station_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="tdate" class="font-weight-bold">Transfer Date <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input class="form-control datepicker" type="date" name="tdate" id="tdate" value="{{ old('tdate') }}" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section mb-4 conditional-field" id="promotion-section">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-briefcase mr-2 text-primary"></i>Promotion Details
                                            </h6>
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="department" class="font-weight-bold">Department <span class="text-danger">*</span></label>
                                                            <select name="department" id="department" class="form-control">
                                                                <option value="">Select Department</option>
                                                                @foreach($departments as $department)
                                                                    <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>
                                                                        {{ $department->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="job_title" class="font-weight-bold">Job Title <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <select name="job_title" id="job_title" class="form-control">
                                                                    <option value="">Select Job Title</option>
                                                                    <option value="cnew">Create New Job Title</option>
                                                                    @foreach($jobtitles as $jobtitle)
                                                                        <option value="{{ $jobtitle->id }}" {{ old('job_title') == $jobtitle->id ? 'selected' : '' }}>
                                                                            {{ $jobtitle->job_title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-primary" type="button" id="add-job-title-btn">
                                                                        <i class="feather icon-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="pdate" class="font-weight-bold">Promotion Date <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input class="form-control datepicker" type="date" name="pdate" id="pdate" value="{{ old('pdate') }}" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-file-text mr-2 text-primary"></i>Additional Information
                                            </h6>
                                            <div class="p-3">
                                                <div class="form-group">
                                                    <label for="reason" class="font-weight-bold">Reason <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="reason" id="reason" rows="3" placeholder="Provide details for the transfer/promotion">{{ old('reason') }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-right p-3 border-top">
                                            <button type="reset" class="btn btn-outline-secondary mr-2">
                                                <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary" id="submission">
                                                <i class="feather icon-save mr-1"></i> Submit <span id="operation-badge"></span>
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

    <!-- Job Title Modal -->
    <div class="modal fade" id="jobTitleModal" tabindex="-1" role="dialog" aria-labelledby="jobTitleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobTitleModalLabel"><i class="feather icon-plus mr-2"></i>Create New Job Title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="job-title-form">
                        <div class="form-group">
                            <label for="jtitle" class="font-weight-bold">Job Title Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="jtitle" name="jtitle" placeholder="Enter job title">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="create-job-title">
                        <i class="feather icon-check mr-1"></i> Create
                    </button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        .modern-form {
            background: #fff;
        }
        
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .form-section {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #fff;
        }
        
        .section-title {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
            border-radius: 8px 8px 0 0;
        }
        
        .select2-container--default .select2-selection--single {
            height: 44px;
            border: 1px solid #dce4ec;
            border-radius: 6px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px;
            padding-left: 15px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }
        
        .form-control {
            border: 1px solid #dce4ec;
            border-radius: 6px;
            transition: all 0.3s ease;
            height: 44px;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        textarea.form-control {
            height: auto;
            resize: vertical;
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #dce4ec;
            color: #2c3e50;
        }
        
        .btn {
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            border-radius: 6px;
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
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .datepicker {
            z-index: 1000 !important;
        }
        
        .operation-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
            background: #e9ecef;
            color: #6c757d;
        }
        
        .badge-promote {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-transfer {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .conditional-field {
            display: none;
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
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '100%'
            });
            
            // Initialize datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
            
            // Show/hide sections based on operation type
            function toggleSections() {
                const operation = $('#operation').val();
                
                if (operation === 'transfer') {
                    $('#transfer-section').show();
                    $('#promotion-section').hide();
                    $('#salary-section').hide();
                    $('#operation-badge').text('Transfer').removeClass('badge-promote').addClass('badge-transfer');
                } else if (operation === 'promote') {
                    $('#transfer-section').hide();
                    $('#promotion-section').show();
                    $('#salary-section').show();
                    $('#operation-badge').text('Promotion').removeClass('badge-transfer').addClass('badge-promote');
                } else {
                    $('#transfer-section').hide();
                    $('#promotion-section').hide();
                    $('#salary-section').hide();
                    $('#operation-badge').text('');
                }
            }
            
            // Initial state
            toggleSections();
            
            // On operation change
            $('#operation').change(function() {
                toggleSections();
            });
            
            // Job title modal handling
            $('#job_title').change(function() {
                if ($(this).val() === 'cnew') {
                    $('#jobTitleModal').modal('show');
                }
            });
            
            $('#add-job-title-btn').click(function() {
                $('#jobTitleModal').modal('show');
            });
            
            $('#create-job-title').click(function() {
                const title = $('#jtitle').val();
                if (title) {
                    // In a real application, you would make an AJAX request to create the job title
                    // For this example, we'll just add it to the select
                    const newOption = $('<option>', {
                        value: 'new_' + Date.now(),
                        text: title,
                        selected: true
                    });
                    
                    $('#job_title').append(newOption);
                    $('#jobTitleModal').modal('hide');
                    $('#jtitle').val('');
                }
            });
            
            // Form validation
            $('form').on('submit', function(e) {
                let isValid = true;
                
                // Check required fields
                $('[required]').each(function() {
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
                }
            });
            
            // Remove validation classes on input
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
            });
        });
    </script>
@endsection