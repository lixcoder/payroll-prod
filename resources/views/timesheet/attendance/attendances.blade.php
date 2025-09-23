@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('bt-datetimepicker/bootstrap-datetimepicker.min.css') }}">
    
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #495057;
            line-height: 24px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .attendance-table th {
            background-color: #4e73df;
            color: white;
            font-weight: 600;
        }
        
        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        
        .modal-header {
            background-color: #4e73df;
            color: white;
        }
        
        .time-input-group {
            display: flex;
            align-items: center;
        }
        
        .time-input-group .form-control {
            flex: 1;
        }
        
        .badge-status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-present {
            background-color: #1cc88a;
            color: white;
        }
        
        .badge-absent {
            background-color: #e74a3b;
            color: white;
        }
        
        .badge-late {
            background-color: #f6c23e;
            color: #2c2929;
        }
        
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-calendar-check mr-2"></i>Employee Attendance
                                    </h5>
                                </div>
                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                                            <i class="fas fa-plus-circle mr-2"></i>Add Attendance Manually
                                        </button>
                                        
                                        <div class="filter-section">
                                            <form id="filter_form" class="form-inline">
                                                <div class="form-group mr-2">
                                                    <label for="day_month_year" class="mr-2">Filter by Date:</label>
                                                    <input type="text" class="form-control form-control-sm date" id="day_month_year" name="day_month_year" autocomplete="off">
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-filter mr-1"></i>Apply Filter
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="daily_attendance-tbl" class="table table-bordered table-hover attendance-table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Employee Name</th>
                                                    <th>Attendance Date</th>
                                                    <th>Status</th>
                                                    <th>Clock In</th>
                                                    <th>Clock Out</th>
                                                    <th>Time Late</th>
                                                    <th>Early Leaving</th>
                                                    <th>Overtime</th>
                                                    <th>Total Work</th>
                                                    <th>Total Rest</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- DataTable will populate this -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="10" class="text-center">Attendance Records</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Attendance Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">
                        <i class="fas fa-plus-circle mr-2"></i>Add Manual Attendance
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addAttendanceForm" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="employee_id">Employee</label>
                            <select id="employee_id" name="employee_id" class="js-example-basic-single form-control" style="width: 100%">
                                @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->first_name.' '.$employee->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="attendance_date">Attendance Date</label>
                            <input type="text" class="form-control datepicker" id="attendance_date" name="attendance_date" autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="shift_id">Shift</label>
                            <select id="shift_id" name="shift_id" class="form-control" onchange="selectShift()">
                                @foreach($shifts as $shift)
                                    <option value="{{$shift->id}}">{{$shift->shift_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="day_display">Selected Day: <span id="day_display" class="font-weight-bold">{{date('l')}}</span></label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="time-input-group">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        <input class="form-control time" placeholder="In Time" type="text" name="clock_in" id="clock_in">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="time-input-group">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        <input class="form-control time" placeholder="Out Time" type="text" name="clock_out" id="clock_out">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="attendance_status">Attendance Status</label>
                            <select id="attendance_status" name="attendance_status" class="form-control">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="leave">Leave</option>
                                <option value="holiday">Holiday</option>
                                <option value="half_day">Half Day</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Save Attendance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script type="text/javascript" src="{{asset('media/jquery-1.8.0.min.js')}}"></script>
    <script src="{{asset('jquery-ui-1.11.4.custom/jquery-ui.js')}}"></script>
    <script src="{{asset('datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('media/js/jquery.dataTables.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('bt-datetimepicker/moment.min.js')}}"></script>
    <script src="{{asset('bt-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    
    <script type="text/javascript">
        (function ($) {
            "use strict";
            
            // Initialize time pickers
            $('.time').datetimepicker({
                format: 'LT'
            });
            
            // Initialize date pickers
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
            
            // Initialize select2
            $(document).ready(function() {
                $('.js-example-basic-single').select2({
                    placeholder: "Select an employee",
                    allowClear: true
                });
                
                // Update day display when date changes
                $('#attendance_date').on('change', function() {
                    const date = new Date($(this).val());
                    const day = date.toLocaleDateString('en-US', { weekday: 'long' });
                    $('#day_display').text(day);
                });
                
                // Initialize DataTable
                fill_datatable();
            });
            
            function fill_datatable(filter_month_year = '') {
                $('#daily_attendance-tbl').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{URL::to('timesheet/attendances')}}",
                        data: {
                            filter_month_year: filter_month_year,
                        }
                    },
                    columns: [
                        {
                            data: 'employee_name',
                            name: 'name'
                        },
                        {
                            data: 'attendance_date',
                            name: 'attendance_date',
                        },
                        {
                            data: 'attendance_status',
                            name: 'attendance_status',
                            render: function(data, type, row) {
                                let badgeClass = 'badge-present';
                                if (data === 'absent') badgeClass = 'badge-absent';
                                if (data === 'late') badgeClass = 'badge-late';
                                
                                return '<span class="badge-status ' + badgeClass + '">' + data.charAt(0).toUpperCase() + data.slice(1) + '</span>';
                            }
                        },
                        {
                            data: 'clock_in',
                            name: 'clock_in',
                        },
                        {
                            data: 'clock_out',
                            name: 'clock_out',
                        },
                        {
                            data: 'time_late',
                            name: 'time_late',
                        },
                        {
                            data: 'early_leaving',
                            name: 'early_leaving',
                        },
                        {
                            data: 'overtime',
                            name: 'overtime',
                        },
                        {
                            data: 'total_work',
                            name: 'total_work'
                        },
                        {
                            data: 'total_rest',
                            name: 'total_rest'
                        }
                    ],
                    order: [[1, 'desc']],
                    language: {
                        lengthMenu: 'Show _MENU_ entries',
                        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                        search: 'Search:',
                        paginate: {
                            previous: 'Previous',
                            next: 'Next'
                        }
                    },
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    pageLength: 10,
                    responsive: true
                });
            }
            
            function selectShift() {
                var shiftId = $('#shift_id').val();
                var dayOfWeek = $('#day_display').text().toLowerCase();
                var clockInField = dayOfWeek + '_in';
                var clockOutField = dayOfWeek + '_out';
                
                $.ajax({
                    url: "{{ url('timesheet/officeshift') }}/" + shiftId + "/" + clockInField + "/" + clockOutField,
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        if (data && data.length > 0) {
                            $('#clock_in').val(data[0][0]);
                            $('#clock_out').val(data[0][1]);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error fetching shift data:', xhr);
                    }
                });
            }
            
            // Filter form submission
            $('#filter_form').on('submit', function(e) {
                e.preventDefault();
                var filter_month_year = $('#day_month_year').val();
                
                $('#daily_attendance-tbl').DataTable().destroy();
                fill_datatable(filter_month_year);
            });

        })(jQuery);
    </script>
@endsection