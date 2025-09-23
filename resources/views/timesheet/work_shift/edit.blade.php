@extends('layouts.main')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    
    <link rel="stylesheet" href="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('bt-datetimepicker/bootstrap-datetimepicker.min.css') }}">
    
    <style>
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .page-title {
            color: #5a5c69;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .form-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .form-section-title {
            color: #4e73df;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .time-input-group {
            display: flex;
            flex-direction: column;
        }
        
        .time-input-group .row {
            margin: 0 -5px;
        }
        
        .time-input-group .col-md-6 {
            padding: 0 5px;
        }
        
        .time-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        
        .day-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 1px solid #e3e6f0;
            transition: all 0.3s ease;
        }
        
        .day-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-color: #4e73df;
        }
        
        .day-header {
            font-weight: 600;
            color: #4e73df;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        
        .day-header i {
            margin-right: 8px;
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            padding: 10px 25px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        
        .btn-info {
            background-color: #36b9cc;
            border-color: #36b9cc;
        }
        
        .btn-info:hover {
            background-color: #2c9faf;
            border-color: #2c9faf;
        }
        
        .alert {
            border-radius: 4px;
            border: none;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .time-input {
            position: relative;
        }
        
        .time-input .form-control {
            padding-left: 35px;
        }
        
        .time-input i {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #6c757d;
        }
        
        .shift-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .status-active {
            background-color: #1cc88a;
            color: white;
        }
        
        .status-inactive {
            background-color: #e74a3b;
            color: white;
        }
        
        @media (max-width: 768px) {
            .day-card {
                margin-bottom: 20px;
            }
        }
    </style>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-edit mr-2"></i>Edit Work Shift: {{ $office_shift->shift_name }}
                                        <span class="shift-status {{ $office_shift->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                            {{ ucfirst($office_shift->status) }}
                                        </span>
                                    </h5>
                                </div>
                                
                                <div class="card-body">
                                    <!-- Flash Messages -->
                                    @if (Session::has('flash_message'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fas fa-check-circle mr-2"></i>{{ Session::get('flash_message') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    
                                    <!-- Error Messages -->
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            <strong>Please fix the following errors:</strong>
                                            <ul class="mb-0 mt-2">
                                                @foreach ($errors as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    
                                    <form method="POST" action="{{ URL::to('timesheet/work_shift/update/' . $office_shift->id) }}" accept-charset="UTF-8">
                                        @csrf
                                        @method('PUT')
                                        
                                        <!-- Shift Information Section -->
                                        <div class="form-section">
                                            <h6 class="form-section-title">
                                                <i class="fas fa-info-circle mr-2"></i>Shift Information
                                            </h6>
                                            
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="shift_name">Shift Name <span class="text-danger">*</span></label>
                                                        <input class="form-control" placeholder="Enter shift name" 
                                                               type="text" name="shift_name" id="shift_name" 
                                                               value="{{ old('shift_name', $office_shift->shift_name) }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="status">Status</label>
                                                        <select class="form-control" name="status" id="status">
                                                            <option value="active" {{ old('status', $office_shift->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                            <option value="inactive" {{ old('status', $office_shift->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Quick Actions</label>
                                                        <div class="d-flex">
                                                            <button type="button" class="btn btn-outline-secondary btn-sm mr-2" onclick="setStandardShift('morning')">
                                                                <i class="fas fa-sun mr-1"></i>Morning
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary btn-sm mr-2" onclick="setStandardShift('evening')">
                                                                <i class="fas fa-moon mr-1"></i>Evening
                                                            </button>
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setStandardShift('night')">
                                                                <i class="fas fa-star mr-1"></i>Night
                                                            </button>
                                                            <button type="button" class="btn btn-outline-info btn-sm ml-auto" onclick="copyMondayToAll()">
                                                                <i class="fas fa-copy mr-1"></i>Copy Monday to All
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Shift Timing Section -->
                                        <div class="form-section">
                                            <h6 class="form-section-title">
                                                <i class="fas fa-clock mr-2"></i>Shift Timings
                                            </h6>
                                            
                                            <div class="row">
                                                <!-- Monday -->
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="day-card">
                                                        <div class="day-header">
                                                            <i class="fas fa-calendar-day"></i>Monday
                                                        </div>
                                                        <div class="time-input-group">
                                                            <span class="time-label">In Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                                <input class="form-control time" placeholder="09:00 AM" 
                                                                       type="text" name="monday_in" 
                                                                       value="{{ old('monday_in', $office_shift->monday_in) }}">
                                                            </div>
                                                        </div>
                                                        <div class="time-input-group mt-2">
                                                            <span class="time-label">Out Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                                <input class="form-control time" placeholder="05:00 PM" 
                                                                       type="text" name="monday_out" 
                                                                       value="{{ old('monday_out', $office_shift->monday_out) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Tuesday -->
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="day-card">
                                                        <div class="day-header">
                                                            <i class="fas fa-calendar-day"></i>Tuesday
                                                        </div>
                                                        <div class="time-input-group">
                                                            <span class="time-label">In Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                                <input class="form-control time" placeholder="09:00 AM" 
                                                                       type="text" name="tuesday_in" 
                                                                       value="{{ old('tuesday_in', $office_shift->tuesday_in) }}">
                                                            </div>
                                                        </div>
                                                        <div class="time-input-group mt-2">
                                                            <span class="time-label">Out Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                                <input class="form-control time" placeholder="05:00 PM" 
                                                                       type="text" name="tuesday_out" 
                                                                       value="{{ old('tuesday_out', $office_shift->tuesday_out) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Wednesday -->
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="day-card">
                                                        <div class="day-header">
                                                            <i class="fas fa-calendar-day"></i>Wednesday
                                                        </div>
                                                        <div class="time-input-group">
                                                            <span class="time-label">In Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                                <input class="form-control time" placeholder="09:00 AM" 
                                                                       type="text" name="wednesday_in" 
                                                                       value="{{ old('wednesday_in', $office_shift->wednesday_in) }}">
                                                            </div>
                                                        </div>
                                                        <div class="time-input-group mt-2">
                                                            <span class="time-label">Out Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                                <input class="form-control time" placeholder="05:00 PM" 
                                                                       type="text" name="wednesday_out" 
                                                                       value="{{ old('wednesday_out', $office_shift->wednesday_out) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Thursday -->
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="day-card">
                                                        <div class="day-header">
                                                            <i class="fas fa-calendar-day"></i>Thursday
                                                        </div>
                                                        <div class="time-input-group">
                                                            <span class="time-label">In Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                                <input class="form-control time" placeholder="09:00 AM" 
                                                                       type="text" name="thursday_in" 
                                                                       value="{{ old('thursday_in', $office_shift->thursday_in) }}">
                                                            </div>
                                                        </div>
                                                        <div class="time-input-group mt-2">
                                                            <span class="time-label">Out Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                                <input class="form-control time" placeholder="05:00 PM" 
                                                                       type="text" name="thursday_out" 
                                                                       value="{{ old('thursday_out', $office_shift->thursday_out) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Friday -->
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="day-card">
                                                        <div class="day-header">
                                                            <i class="fas fa-calendar-day"></i>Friday
                                                        </div>
                                                        <div class="time-input-group">
                                                            <span class="time-label">In Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                                <input class="form-control time" placeholder="09:00 AM" 
                                                                       type="text" name="friday_in" 
                                                                       value="{{ old('friday_in', $office_shift->friday_in) }}">
                                                            </div>
                                                        </div>
                                                        <div class="time-input-group mt-2">
                                                            <span class="time-label">Out Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                                <input class="form-control time" placeholder="05:00 PM" 
                                                                       type="text" name="friday_out" 
                                                                       value="{{ old('friday_out', $office_shift->friday_out) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Saturday -->
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="day-card">
                                                        <div class="day-header">
                                                            <i class="fas fa-calendar-day"></i>Saturday
                                                        </div>
                                                        <div class="time-input-group">
                                                            <span class="time-label">In Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                                <input class="form-control time" placeholder="09:00 AM" 
                                                                       type="text" name="saturday_in" 
                                                                       value="{{ old('saturday_in', $office_shift->saturday_in) }}">
                                                            </div>
                                                        </div>
                                                        <div class="time-input-group mt-2">
                                                            <span class="time-label">Out Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                                <input class="form-control time" placeholder="05:00 PM" 
                                                                       type="text" name="saturday_out" 
                                                                       value="{{ old('saturday_out', $office_shift->saturday_out) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Sunday -->
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="day-card">
                                                        <div class="day-header">
                                                            <i class="fas fa-calendar-day"></i>Sunday
                                                        </div>
                                                        <div class="time-input-group">
                                                            <span class="time-label">In Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-in-alt"></i>
                                                                <input class="form-control time" placeholder="09:00 AM" 
                                                                       type="text" name="sunday_in" 
                                                                       value="{{ old('sunday_in', $office_shift->sunday_in) }}">
                                                            </div>
                                                        </div>
                                                        <div class="time-input-group mt-2">
                                                            <span class="time-label">Out Time</span>
                                                            <div class="time-input">
                                                                <i class="fas fa-sign-out-alt"></i>
                                                                <input class="form-control time" placeholder="05:00 PM" 
                                                                       type="text" name="sunday_out" 
                                                                       value="{{ old('sunday_out', $office_shift->sunday_out) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Form Actions -->
                                        <div class="form-actions text-right mt-4">
                                            <a href="{{ URL::to('timesheet/work_shift') }}" class="btn btn-secondary mr-2">
                                                <i class="fas fa-arrow-left mr-1"></i>Back to List
                                            </a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save mr-1"></i>Update Shift
                                            </button>
                                        </div>
                                    </form>
                                    
                                    <!-- Additional Options -->
                                    <div class="mt-4 pt-3 border-top">
                                        <h6 class="text-muted mb-3">Additional Options</h6>
                                        <div class="d-flex">
                                            <a href="{{ URL::to('timesheet/work_shift/clone/' . $office_shift->id) }}" class="btn btn-outline-info btn-sm mr-2">
                                                <i class="fas fa-copy mr-1"></i>Clone This Shift
                                            </a>
                                            <form action="{{ URL::to('timesheet/work_shift/deactivate/' . $office_shift->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this shift?')">
                                                    <i class="fas fa-trash-alt mr-1"></i>Delete Shift
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.js') }}"></script>
    <script src="{{ asset('bt-datetimepicker/moment.min.js') }}"></script>
    <script src="{{ asset('bt-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script type="text/javascript">
        (function ($) {
            "use strict";
            
            // Initialize time pickers
            $('.time').datetimepicker({
                format: 'LT',
                icons: {
                    time: 'fas fa-clock',
                    date: 'fas fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-calendar-check',
                    clear: 'fas fa-trash',
                    close: 'fas fa-times'
                }
            });
            
            // Set standard shift timings
            function setStandardShift(type) {
                let inTime, outTime;
                
                switch(type) {
                    case 'morning':
                        inTime = '08:00 AM';
                        outTime = '05:00 PM';
                        $('#shift_name').val('Morning Shift');
                        break;
                    case 'evening':
                        inTime = '02:00 PM';
                        outTime = '11:00 PM';
                        $('#shift_name').val('Evening Shift');
                        break;
                    case 'night':
                        inTime = '10:00 PM';
                        outTime = '07:00 AM';
                        $('#shift_name').val('Night Shift');
                        break;
                }
                
                // Set times for all days
                $('input[name$="_in"]').val(inTime);
                $('input[name$="_out"]').val(outTime);
                
                toastr.success(`${type.charAt(0).toUpperCase() + type.slice(1)} shift timings applied`);
            }
            
            // Copy Monday times to all days
            function copyMondayToAll() {
                const mondayIn = $('input[name="monday_in"]').val();
                const mondayOut = $('input[name="monday_out"]').val();
                
                if (mondayIn && mondayOut) {
                    // Set times for all days except Monday
                    $('input[name$="_in"]').not('[name="monday_in"]').val(mondayIn);
                    $('input[name$="_out"]').not('[name="monday_out"]').val(mondayOut);
                    
                    toastr.success('Monday timings copied to all days');
                } else {
                    toastr.error('Please set Monday times first');
                }
            }
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
            
        })(jQuery);
    </script>
@stop