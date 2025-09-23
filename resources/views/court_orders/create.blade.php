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
                                        <h5 class="mb-0"><i class="feather icon-file-text mr-2 text-primary"></i>New Court Order</h5>
                                        <small class="text-muted">Create a new court order record</small>
                                    </div>
                                    <div class="card-header-right">
                                        <a href="{{ URL::to('court_orders') }}" class="btn btn-secondary btn-sm">
                                            <i class="feather icon-arrow-left mr-1"></i> Back to Court Orders
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
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

                                <form method="POST" action="{{ url('court_orders') }}" class="modern-form">
                                    @csrf
                                    
                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-info mr-2 text-primary"></i>Basic Information
                                        </h6>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="order_number" class="font-weight-bold">Court Order Number <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="text" name="order_number" id="order_number"
                                                               value="{{ old('order_number') }}" placeholder="Enter court order number" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="order_type" class="font-weight-bold">Order Type <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="order_type" id="order_type" required>
                                                            <option value="">Select Order Type</option>
                                                            <option value="garnishment" {{ old('order_type') == 'garnishment' ? 'selected' : '' }}>Garnishment</option>
                                                            <option value="attachment" {{ old('order_type') == 'attachment' ? 'selected' : '' }}>Attachment</option>
                                                            <option value="deduction" {{ old('order_type') == 'deduction' ? 'selected' : '' }}>Deduction</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description" class="font-weight-bold">Description</label>
                                                <textarea class="form-control" name="description" id="description" rows="3" 
                                                          placeholder="Enter court order description">{{ old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-calendar mr-2 text-primary"></i>Date Information
                                        </h6>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="effective_date" class="font-weight-bold">Effective Date <span class="text-danger">*</span></label>
                                                        <input class="form-control datepicker" type="date" name="effective_date" id="effective_date"
                                                               value="{{ old('effective_date') }}" placeholder="Select effective date" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="end_date" class="font-weight-bold">End Date</label>
                                                        <input class="form-control datepicker" type="date" name="end_date" id="end_date"
                                                               value="{{ old('end_date') }}" placeholder="Select end date (optional)">
                                                        <small class="form-text text-muted">Leave blank for ongoing orders</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-section mb-4">
                                        <h6 class="section-title bg-light p-3 border-bottom">
                                            <i class="feather icon-percent mr-2 text-primary"></i>Financial Details
                                        </h6>
                                        <div class="p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rate_type" class="font-weight-bold">Rate Type <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="rate_type" id="rate_type" required>
                                                            <option value="">Select Rate Type</option>
                                                            <option value="fixed" {{ old('rate_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                                            <option value="percentage" {{ old('rate_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6" id="amount-field">
                                                    <div class="form-group">
                                                        <label for="amount" class="font-weight-bold">Amount</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input class="form-control" type="text" name="amount" id="amount"
                                                                   value="{{ old('amount') }}" placeholder="0.00">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="percentage-field" style="display: none;">
                                                    <div class="form-group">
                                                        <label for="percentage" class="font-weight-bold">Percentage</label>
                                                        <div class="input-group">
                                                            <input class="form-control" type="text" name="percentage" id="percentage"
                                                                   value="{{ old('percentage') }}" placeholder="0.00">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions text-right p-3 border-top">
                                        <button type="reset" class="btn btn-outline-secondary mr-2">
                                            <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather icon-save mr-1"></i> Create Court Order
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
            todayHighlight: true,
            endDate: new Date()
        });
        
        // Initialize amount input mask
        $('#amount').inputmask('decimal', {
            rightAlign: false,
            digits: 2,
            placeholder: '0.00',
            radixPoint: ".",
            groupSeparator: ","
        });
        
        // Initialize percentage input mask
        $('#percentage').inputmask('decimal', {
            rightAlign: false,
            digits: 2,
            placeholder: '0.00',
            radixPoint: ".",
            groupSeparator: ","
        });
        
        // Handle rate type change
        $('#rate_type').change(function() {
            if ($(this).val() === 'fixed') {
                $('#amount-field').show();
                $('#percentage-field').hide();
                $('#amount').prop('required', true);
                $('#percentage').prop('required', false);
            } else if ($(this).val() === 'percentage') {
                $('#amount-field').hide();
                $('#percentage-field').show();
                $('#amount').prop('required', false);
                $('#percentage').prop('required', true);
            } else {
                $('#amount-field').hide();
                $('#percentage-field').hide();
                $('#amount').prop('required', false);
                $('#percentage').prop('required', false);
            }
        });
        
        // Trigger rate type change on page load
        $('#rate_type').trigger('change');
        
        // Form validation
        $('form').on('submit', function(e) {
            let isValid = true;
            
            // Basic validation
            $('#order_number, #order_type, #effective_date, #rate_type').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            // Conditional validation for amount/percentage
            if ($('#rate_type').val() === 'fixed' && !$('#amount').val()) {
                $('#amount').addClass('is-invalid');
                isValid = false;
            }
            
            if ($('#rate_type').val() === 'percentage' && !$('#percentage').val()) {
                $('#percentage').addClass('is-invalid');
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
        $('input, select, textarea').on('input change', function() {
            $(this).removeClass('is-invalid');
        });
    });
</script>
@stop