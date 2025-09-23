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
                                            <h5 class="mb-0"><i class="feather icon-file-text mr-2 text-primary"></i>Payroll Reports</h5>
                                            <small class="text-muted">Generate detailed payroll reports and payslips</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('payroll') }}" class="btn btn-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i> Back to Payroll
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
                                    
                                    @if (Session::get('notice'))
                                        <div class="alert alert-info alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-info mr-2"></i> {{ Session::get('notice') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ URL::to('payrollReports/payslip') }}" class="modern-form">
                                        @csrf
                                        
                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-calendar mr-2 text-primary"></i>Period Selection
                                            </h6>
                                            <div class="p-3">
                                                <div class="form-group">
                                                    <label for="period" class="font-weight-bold">Period <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input required class="form-control datepicker2" placeholder="Select period" type="text" name="period" id="period" value="{{ old('period') }}">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-filter mr-2 text-primary"></i>Filter Options
                                            </h6>
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="branchid" class="font-weight-bold">Select Branch <span class="text-danger">*</span></label>
                                                            <select required name="branchid" id="branchid" class="form-control select2">
                                                                <option value="">Select Branch</option>
                                                                <option value="All" {{ old('branchid') == 'All' ? 'selected' : '' }}>All Branches</option>
                                                                @foreach($branches as $branch)
                                                                    <option value="{{ $branch->id }}" {{ old('branchid') == $branch->id ? 'selected' : '' }}>
                                                                        {{ $branch->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="departmentid" class="font-weight-bold">Select Department <span class="text-danger">*</span></label>
                                                            <select required name="departmentid" id="departmentid" class="form-control select2">
                                                                <option value="">Select Department</option>
                                                                <option value="All" {{ old('departmentid') == 'All' ? 'selected' : '' }}>All Departments</option>
                                                                @foreach($departments as $department)
                                                                    <option value="{{ $department->id }}" {{ old('departmentid') == $department->id ? 'selected' : '' }}>
                                                                        {{ $department->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="employeeid" class="font-weight-bold">Select Employee <span class="text-danger">*</span></label>
                                                    <select required name="employeeid" id="employeeid" class="form-control select2">
                                                        <option value="">Select Employee</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{ $employee->id }}" {{ old('employeeid') == $employee->id ? 'selected' : '' }}>
                                                                {{ $employee->first_name . ' ' . $employee->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-download mr-2 text-primary"></i>Export Options
                                            </h6>
                                            <div class="p-3">
                                                <div class="form-group">
                                                    <label for="format" class="font-weight-bold">Download as <span class="text-danger">*</span></label>
                                                    <select required name="format" class="form-control">
                                                        <option value="">Select Format</option>
                                                        <option value="excel" {{ old('format') == 'excel' ? 'selected' : '' }}>Excel</option>
                                                        <option value="pdf" {{ old('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-right p-3 border-top">
                                            <button type="reset" class="btn btn-outline-secondary mr-2">
                                                <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="feather icon-download mr-1"></i> Generate Report
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
    <link rel="stylesheet" href="{{ asset('datepicker/css/bootstrap-datepicker.css') }}">
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
    <script src="{{ asset('datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '100%'
            });
            
            // Initialize datepicker
            $('.datepicker2').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
            
            // Branch change event
            $('#branchid').change(function() {
                $.get("{{ url('api/branchemployee')}}",
                    {
                        option: $(this).val(),
                        deptid: $('#departmentid').val()
                    },
                    function(data) {
                        $('#employeeid').empty();
                        $('#employeeid').append("<option value=''>Select Employee</option>");
                        $.each(data, function(key, element) {
                            $('#employeeid').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    }
                );
            });
            
            // Department change event
            $('#departmentid').change(function() {
                $.get("{{ url('api/deptemployee')}}",
                    {
                        option: $(this).val(),
                        bid: $('#branchid').val()
                    },
                    function(data1) {
                        $('#employeeid').empty();
                        $('#employeeid').append("<option value=''>Select Employee</option>");
                        $.each(data1, function(key, element) {
                            $('#employeeid').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    }
                );
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
            $('input, select').on('input change', function() {
                $(this).removeClass('is-invalid');
            });
        });
    </script>
@endsection