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
                                            <h5 class="mb-0"><i class="feather icon-edit-2 mr-2 text-warning"></i>Update Leave Type</h5>
                                            <small class="text-muted">Modify leave type details and entitlements</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('leavetypes') }}" class="btn btn-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i> Back to Leave Types
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

                                    <form method="POST" action="{{ url('leavetypes/update/'.$leavetype->id) }}" class="modern-form">
                                        @csrf
                                        
                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-info mr-2 text-primary"></i>Leave Type Details
                                            </h6>
                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name" class="font-weight-bold">Leave Type Name <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-light"><i class="feather icon-tag"></i></span>
                                                                </div>
                                                                <input class="form-control" placeholder="e.g., Annual Leave, Sick Leave" type="text" name="name" id="name" value="{{ $leavetype->name }}" required>
                                                            </div>
                                                            <small class="form-text text-muted">Enter a descriptive name for the leave type</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="days" class="font-weight-bold">Days Entitled <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-light"><i class="feather icon-calendar"></i></span>
                                                                </div>
                                                                <input class="form-control" placeholder="e.g., 21" type="number" name="days" id="days" value="{{ $leavetype->days }}" min="1" max="365" required>
                                                            </div>
                                                            <small class="form-text text-muted">Number of days employees are entitled to</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold d-block">Holiday Inclusion</label>
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" name="in_holidays" id="in_holidays" value="1" {{ $leavetype->in_holidays ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="in_holidays">Include holidays in leave days</label>
                                                            </div>
                                                            <small class="form-text text-muted">When enabled, holidays will be counted as leave days</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold d-block">Weekend Inclusion</label>
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" name="in_weekends" id="in_weekends" value="1" {{ $leavetype->in_weekends ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="in_weekends">Include weekends in leave days</label>
                                                            </div>
                                                            <small class="form-text text-muted">When enabled, weekends will be counted as leave days</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-right p-3 border-top">
                                            <button type="reset" class="btn btn-outline-secondary mr-2">
                                                <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="feather icon-save mr-1"></i> Update Leave Type
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
        
        .custom-switch {
            padding-left: 3rem;
        }
        
        .custom-control-input:checked ~ .custom-control-label::before {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border-color: #f39c12;
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