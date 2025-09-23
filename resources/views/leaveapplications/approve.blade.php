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
                                            <h5 class="mb-0"><i class="feather icon-check-circle mr-2 text-success"></i>Approve Leave</h5>
                                            <small class="text-muted">Review and approve leave application</small>
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

                                    <div class="application-details mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-info mr-2 text-primary"></i>Application Details
                                        </h6>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="detail-item mb-3">
                                                        <label class="font-weight-bold text-muted">Employee</label>
                                                        <p class="mb-0">{{$leaveapplication->employee->first_name.' '.$leaveapplication->employee->last_name.' '.$leaveapplication->employee->middle_name}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item mb-3">
                                                        <label class="font-weight-bold text-muted">Leave Type</label>
                                                        <p class="mb-0">{{$leaveapplication->leavetype->name}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item mb-3">
                                                        <label class="font-weight-bold text-muted">Application Date</label>
                                                        <p class="mb-0">{{date('d-M-Y', strtotime($leaveapplication->application_date))}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item mb-3">
                                                        <label class="font-weight-bold text-muted">Applied Start Date</label>
                                                        <p class="mb-0">{{date('d-M-Y', strtotime($leaveapplication->applied_start_date))}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item mb-3">
                                                        <label class="font-weight-bold text-muted">Applied End Date</label>
                                                        <p class="mb-0">{{date('d-M-Y', strtotime($leaveapplication->applied_end_date))}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="detail-item mb-3">
                                                        <label class="font-weight-bold text-muted">Leave Days</label>
                                                        <p class="mb-0 badge badge-primary">
                                                            {{App\models\Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date)}} days
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ url('leaveapplications/approve/'.$leaveapplication->id) }}" class="modern-form">
                                        @csrf
                                        
                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-calendar mr-2 text-primary"></i>Approval Details
                                            </h6>
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="approved_start_date" class="font-weight-bold">Approved Start Date <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-light"><i class="feather icon-calendar"></i></span>
                                                                </div>
                                                                <input required class="form-control" type="date" name="approved_start_date" id="approved_start_date" value="{{ \Carbon\Carbon::parse($leaveapplication->applied_start_date)->format('Y-m-d') }}">
                                                            </div>
                                                            <small class="form-text text-muted">Select the approved start date</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="approved_end_date" class="font-weight-bold">Approved End Date <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-light"><i class="feather icon-calendar"></i></span>
                                                                </div>
                                                                <input required class="form-control" type="date" name="approved_end_date" id="approved_end_date" value="{{ \Carbon\Carbon::parse($leaveapplication->applied_end_date)->format('Y-m-d') }}">
                                                            </div>
                                                            <small class="form-text text-muted">Select the approved end date</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="alert alert-info mt-3">
                                                    <i class="feather icon-info mr-2"></i>
                                                    You can adjust the dates if necessary before approving the leave.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-right p-3 border-top">
                                            <a href="{{ URL::to('leaveapplications') }}" class="btn btn-outline-secondary mr-2">
                                                <i class="feather icon-x mr-1"></i> Cancel
                                            </a>
                                            <button type="submit" class="btn btn-success">
                                                <i class="feather icon-check mr-1"></i> Approve Leave
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
            background: linear-gradient(135deg, #f0fff4 0%, #c6f6d5 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .application-details, .form-section {
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
        
        .detail-item {
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .detail-item:last-child {
            border-bottom: none;
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
        
        .btn-success {
            background: linear-gradient(135deg, #38a169 0%, #48bb78 100%);
            border: none;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
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
                
                // Validate date order
                const startDate = new Date($('#approved_start_date').val());
                const endDate = new Date($('#approved_end_date').val());
                
                if (startDate > endDate) {
                    $('#approved_start_date, #approved_end_date').addClass('is-invalid');
                    alert('End date cannot be before start date');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                }
            });
            
            // Remove validation classes on input
            $('input').on('input', function() {
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