@extends('layouts.leave')
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
                                            <h5 class="mb-0"><i class="feather icon-edit-2 mr-2 text-warning"></i>Update Leave Application</h5>
                                            <small class="text-muted">Modify leave application details</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('leaveapplications') }}" class="btn btn-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i> Back to Applications
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong><i class="feather icon-alert-triangle mr-2"></i> Please fix the following errors:</strong>
                                            <ul class="mb-0 mt-2">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ url('leaveapplications/update/'.$leaveapplication->id) }}" class="modern-form">
                                        @csrf
                                        
                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-info mr-2 text-primary"></i>Application Details
                                            </h6>
                                            <div class="p-3">
                                                <div class="form-group">
                                                    <label for="employee_id" class="font-weight-bold">Employee <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light"><i class="feather icon-user"></i></span>
                                                        </div>
                                                        <select class="form-control" name="employee_id" required>
                                                            <option value="{{$leaveapplication->employee->id}}">{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->last_name." ".$leaveapplication->employee->middle_name}} ({{$leaveapplication->employee->personal_file_number}})</option>
                                                            @foreach($employees as $employee)
                                                                <option value="{{$employee->id}}">{{$employee->first_name." ".$employee->last_name." ".$employee->middle_name}} ({{$employee->personal_file_number}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <small class="form-text text-muted">Select the employee requesting leave</small>
                                                </div>

                                                <div class="form-group mt-4">
                                                    <label for="leavetype_id" class="font-weight-bold">Leave Type <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light"><i class="feather icon-briefcase"></i></span>
                                                        </div>
                                                        <select class="form-control" name="leavetype_id" required>
                                                            <option value="{{$leaveapplication->leavetype->id}}">{{$leaveapplication->leavetype->name}}</option>
                                                            @foreach($leavetypes as $leavetype)
                                                                <option value="{{$leavetype->id}}">{{$leavetype->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <small class="form-text text-muted">Select the type of leave being requested</small>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applied_start_date" class="font-weight-bold">Start Date <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-light"><i class="feather icon-calendar"></i></span>
                                                                </div>
                                                                <input required class="form-control" type="date" name="applied_start_date" id="applied_start_date" value="{{ \Carbon\Carbon::parse($leaveapplication->applied_start_date)->format('Y-m-d') }}">
                                                            </div>
                                                            <small class="form-text text-muted">Select the start date of leave</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applied_end_date" class="font-weight-bold">End Date <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-light"><i class="feather icon-calendar"></i></span>
                                                                </div>
                                                                <input required class="form-control" type="date" name="applied_end_date" id="applied_end_date" value="{{ \Carbon\Carbon::parse($leaveapplication->applied_end_date)->format('Y-m-d') }}">
                                                            </div>
                                                            <small class="form-text text-muted">Select the end date of leave</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="alert alert-info mt-4">
                                                    <i class="feather icon-info mr-2"></i>
                                                    Original Application Date: {{ \Carbon\Carbon::parse($leaveapplication->application_date)->format('M d, Y') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-right p-3 border-top">
                                            <button type="reset" class="btn btn-outline-secondary mr-2">
                                                <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="feather icon-save mr-1"></i> Update Application
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
        .modern-form {
            background: #fff;
        }
        
        .card-header {
            background: linear-gradient(135deg, #fef9e7 0%, #f7dc6f 100%);
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
        
        .form-control {
            border: 1px solid #dce4ec;
            border-radius: 6px;
            transition: all 0.3s ease;
            height: 44px;
            padding: 10px 15px;
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
        
        .btn-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border: none;
            color: white;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            color: white;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
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

    <script>
        $(document).ready(function() {
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
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@stop