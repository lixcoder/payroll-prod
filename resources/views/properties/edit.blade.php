@extends('layouts.main')

@section('content')
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
                                        <h5 class="mb-0"><i class="feather icon-edit mr-2 text-primary"></i>Update Property</h5>
                                        <small class="text-muted">Edit company property assignment details</small>
                                    </div>
                                    <div class="card-header-right">
                                        <a href="{{ URL::to('Properties') }}" class="btn btn-secondary btn-sm">
                                            <i class="feather icon-arrow-left mr-1"></i> Back to Properties
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

                                <form method="POST" action="{{ URL::to('Properties/update/'.$property->id) }}" accept-charset="UTF-8" class="modern-form">
                                    @csrf
                                    
                                    <input type="hidden" readonly name="retby" id="retby" value="{{ Confide::user()->username }}">
                                    <input type="hidden" readonly name="employee_id" id="employee_id" value="{{ $property->employee->id }}">

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-user mr-2 text-primary"></i>Employee Information
                                        </h6>
                                        <div class="p-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Assigned Employee</label>
                                                <div class="employee-display bg-light p-3 rounded">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary rounded-circle mr-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="feather icon-user text-white"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $property->employee->first_name.' '.$property->employee->middle_name.' '.$property->employee->last_name }}</h6>
                                                            <small class="text-muted">Employee ID: {{ $property->employee->id }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">Employee assignment cannot be changed once created.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-box mr-2 text-primary"></i>Property Details
                                        </h6>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name" class="font-weight-bold">Property Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" placeholder="Enter property name" type="text" name="name" id="name" value="{{ $property->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="amount" class="font-weight-bold">Value <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-light">{{ $currency->shortname }}</span>
                                                            </div>
                                                            <input class="form-control" placeholder="0.00" type="text" name="amount" id="amount" value="{{ asMoney($property->monetary) }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="desc" class="font-weight-bold">Description</label>
                                                <textarea class="form-control" name="desc" id="desc" rows="3" placeholder="Enter property description">{{ $property->description }}</textarea>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="serial" class="font-weight-bold">Serial Number</label>
                                                        <input class="form-control" placeholder="Enter serial number" type="text" name="serial" id="serial" value="{{ $property->serial }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="dserial" class="font-weight-bold">Digital Serial Number</label>
                                                        <input class="form-control" placeholder="Enter digital serial" type="text" name="dserial" id="dserial" value="{{ $property->digitalserial }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-calendar mr-2 text-primary"></i>Assignment Details
                                        </h6>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="issuedby" class="font-weight-bold">Issued By</label>
                                                        <input class="form-control" readonly type="text" name="issuedby" id="issuedby" value="{{ $user->username }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="idate" class="font-weight-bold">Issue Date <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input class="form-control datepicker" readonly type="text" name="idate" id="idate" value="{{ $property->issue_date }}" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="sdate" class="font-weight-bold">Scheduled Return Date <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input class="form-control datepicker" readonly type="text" name="sdate" id="sdate" value="{{ $property->scheduled_return_date }}" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold d-block">Return Status</label>
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="active" id="active" {{ $property->state == 1 ? 'checked disabled' : '' }}>
                                                            <label class="custom-control-label" for="active">Mark as Returned</label>
                                                        </div>
                                                        @if($property->state == 1)
                                                            <small class="form-text text-success">This property has already been returned.</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="receivedByGroup" style="{{ $property->state == 1 ? '' : 'display: none;' }}">
                                                <label for="receivedby" class="font-weight-bold">Received By</label>
                                                @if($property->state == 1)
                                                    <input class="form-control" readonly type="text" name="receivedby" id="receivedby" value="{{ $retuser->username }}">
                                                @else
                                                    <input class="form-control" readonly type="text" name="receivedby" id="receivedby">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions text-right p-3 border-top">
                                        <button type="reset" class="btn btn-outline-secondary mr-2">
                                            <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather icon-save mr-1"></i> Update Property
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
    
    .employee-display {
        border: 1px solid #e9ecef;
        border-radius: 6px;
    }
    
    .avatar {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
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
    
    .custom-switch .custom-control-label::before {
        border: 1px solid #dce4ec;
    }
    
    .custom-control-input:checked ~ .custom-control-label::before {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        border-color: #1e3c72;
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize datepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
        
        // Initialize amount input mask
        $('#amount').inputmask('decimal', {
            rightAlign: false,
            digits: 2,
            placeholder: '0.00',
            radixPoint: ".",
            groupSeparator: ","
        });
        
        // Handle return status toggle
        $('#active').change(function() {
            if (this.checked) {
                $('#receivedByGroup').slideDown(300);
                $('#receivedby').val($('#retby').val());
            } else {
                $('#receivedByGroup').slideUp(300);
                $('#receivedby').val('');
            }
        });
        
        // Form validation
        $('form').on('submit', function(e) {
            let isValid = true;
            
            // Basic validation
            $('#name, #amount, #idate, #sdate').each(function() {
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
@stop