@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        {{-- Alert Messages --}}
                        @if (Session::has('flash_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <div>{{ Session::get('flash_message') }}</div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('delete_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <div>{{ Session::get('delete_message') }}</div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (Session::has('import_errors'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    <div>
                                        <strong>Import failed!</strong> Please fix the following errors and try again:
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <ul class="mt-2 mb-0 pl-3">
                                    @foreach (Session::get('import_errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0"><i class="fas fa-users mr-2 text-primary"></i> Employee Management</h5>
                                    <small class="text-muted">Manage active employees and probation staff</small>
                                </div>
                                <div class="card-header-right">
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-primary btn-sm" href="{{ url('employees/create')}}">
                                            <i class="fas fa-user-plus mr-1"></i> New Employee
                                        </a>
                                        <button id="refresh" class="btn btn-success btn-sm ml-1">
                                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                                        </button>
                                        <button class="btn btn-info btn-sm ml-1" data-toggle="modal" data-target="#importEmployees">
                                            <i class="fas fa-upload mr-1"></i> Upload
                                        </button>
                                        <a href="{{url('employee/template')}}" class="btn btn-warning btn-sm ml-1">
                                            <i class="fas fa-download mr-1"></i> Template
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Import Modal --}}
                        <div class="modal fade" id="importEmployees">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title"><i class="fas fa-upload mr-2"></i>Import Employees</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('employees.import')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="form-label font-weight-bold">Select Excel File</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="file" required>
                                                    <label class="custom-file-label" for="customFile">Choose file...</label>
                                                </div>
                                                <small class="form-text text-muted">Please use the provided template format</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                                <i class="fas fa-times mr-1"></i> Cancel
                                            </button>
                                            <button type="submit" class="btn btn-info">
                                                <i class="fas fa-upload mr-1"></i> Upload
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-block">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#active" data-toggle="tab">
                                                <i class="fas fa-user-check mr-1"></i> Active Employees
                                                <span class="badge badge-primary ml-1">{{ count($employees) }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#probation" data-toggle="tab">
                                                <i class="fas fa-user-clock mr-1"></i> On Probation
                                                <span class="badge badge-warning ml-1">{{ count($probation) }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="card-body">
                                    <div class="tab-content">
                                        {{-- Active Employees Tab --}}
                                        <div id="active" class="tab-pane active">
                                            @if(count($employees) > 0)
                                                <div class="table-responsive">
                                                    <table id="activeEmployeesTable" class="table table-hover table-striped">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>PFN</th>
                                                                <th>Employee Name</th>
                                                                <th>ID Number</th>
                                                                <th>KRA Pin</th>
                                                                <th>NSSF</th>
                                                                <th>NHIF</th>
                                                                <th>Gender</th>
                                                                <th>Employee Type</th>
                                                                <th>Branch</th>
                                                                <th>Department</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($employees as $employee)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td><span class="badge badge-secondary">{{ $employee->personal_file_number }}</span></td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px;">
                                                                                <i class="fas fa-user"></i>
                                                                            </div>
                                                                            <div>
                                                                                {{ $employee->first_name }} 
                                                                                {{ $employee->middle_name ? $employee->middle_name . ' ' : '' }}
                                                                                {{ $employee->last_name }}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $employee->identity_number }}</td>
                                                                    <td>{{ $employee->pin }}</td>
                                                                    <td>{{ $employee->social_security_number }}</td>
                                                                    <td>{{ $employee->hospital_insurance_number }}</td>
                                                                    <td>
                                                                        <span class="badge badge-info">{{ $employee->gender }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            try {
                                                                                if($employee->employeeY->employee_type_name == 'Contract') {
                                                                                    $start_date = $employee->end_date;
                                                                                    $today = new DateTime(today());
                                                                                    $end = new DateTime($start_date);
                                                                                    $interval = $today->diff($end);
                                                                                    echo '<span class="badge badge-warning">'.$employee->employeeY->employee_type_name.'</span><br>';
                                                                                    echo '<small class="text-muted">'.$interval->m.'M '.$interval->d.'D remaining</small>';
                                                                                } else {
                                                                                    echo '<span class="badge badge-success">'.$employee->employeeY->employee_type_name.'</span>';
                                                                                }
                                                                            } catch (\Exception $e) {
                                                                                echo '<span class="badge badge-secondary">N/A</span>';
                                                                            }
                                                                        @endphp
                                                                    </td>
                                                                    <td>
                                                                        @if($employee->branch_id != 0)
                                                                            <span class="badge badge-light">{{ App\Models\Branch::getName($employee->branch_id) }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($employee->department_id != 0)
                                                                            {{ App\Models\Department::getName($employee->department_id) }}
                                                                            <br>
                                                                            <small class="text-muted">({{ App\Models\Department::getCode($employee->department_id) }})</small>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group" role="group">
                                                                            <a href="{{url('employees/view/'.$employee->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                            <a href="{{url('employees/edit/'.$employee->id)}}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            <a href="{{url('employees/deactivate/'.$employee->id)}}" 
                                                                               class="btn btn-sm btn-danger" 
                                                                               data-toggle="tooltip" 
                                                                               title="Deactivate"
                                                                               onclick="return confirm('Are you sure you want to deactivate this employee?')">
                                                                                <i class="fas fa-user-times"></i>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="text-center py-5">
                                                    <div class="empty-state">
                                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">No Active Employees</h5>
                                                        <p class="text-muted">Get started by adding your first employee</p>
                                                        <a href="{{url('employees/create')}}" class="btn btn-primary">
                                                            <i class="fas fa-user-plus mr-1"></i> Add Employee
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Probation Employees Tab --}}
                                        <div id="probation" class="tab-pane">
                                            @if(count($probation) > 0)
                                                <div class="table-responsive">
                                                    <table id="probationEmployeesTable" class="table table-hover table-striped">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>#</th>
                                                                <th>PFN</th>
                                                                <th>Employee Name</th>
                                                                <th>ID Number</th>
                                                                <th>KRA Pin</th>
                                                                <th>NSSF</th>
                                                                <th>NHIF</th>
                                                                <th>Gender</th>
                                                                <th>Employee Type</th>
                                                                <th>Branch</th>
                                                                <th>Department</th>
                                                                <th class="text-center">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($probation as $employee)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td><span class="badge badge-secondary">{{ $employee->personal_file_number }}</span></td>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar bg-warning text-white rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px;">
                                                                                <i class="fas fa-user-clock"></i>
                                                                            </div>
                                                                            <div>
                                                                                {{ $employee->first_name }} 
                                                                                {{ $employee->middle_name ? $employee->middle_name . ' ' : '' }}
                                                                                {{ $employee->last_name }}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>{{ $employee->identity_number }}</td>
                                                                    <td>{{ $employee->pin }}</td>
                                                                    <td>{{ $employee->social_security_number }}</td>
                                                                    <td>{{ $employee->hospital_insurance_number }}</td>
                                                                    <td>
                                                                        <span class="badge badge-info">{{ $employee->gender }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @php
                                                                            $etype = DB::table('x_employee_type')->where('id', '=', $employee->type_id)->pluck('employee_type_name')->first();
                                                                        @endphp
                                                                        <span class="badge badge-warning">{{ $etype }}</span>
                                                                    </td>
                                                                    <td>
                                                                        @if($employee->branch_id != 0)
                                                                            <span class="badge badge-light">{{ App\Models\Branch::getName($employee->branch_id) }}</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($employee->department_id != 0)
                                                                            {{ App\Models\Department::getName($employee->department_id) }}
                                                                            <br>
                                                                            <small class="text-muted">({{ App\Models\Department::getCode($employee->department_id) }})</small>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="btn-group" role="group">
                                                                            <a href="{{url('employees/view/'.$employee->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                            <a href="{{url('employees/edit/'.$employee->id)}}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                            <a href="{{url('employees/deactivate/'.$employee->id)}}" 
                                                                               class="btn btn-sm btn-danger" 
                                                                               data-toggle="tooltip" 
                                                                               title="Deactivate"
                                                                               onclick="return confirm('Are you sure you want to deactivate this employee?')">
                                                                                <i class="fas fa-user-times"></i>
                                                                            </a>
                                                                            <button class="btn btn-sm btn-success" 
                                                                                    data-toggle="modal" 
                                                                                    data-target="#confirmEmployee{{$employee->id}}"
                                                                                    data-toggle="tooltip" 
                                                                                    title="Confirm Employee">
                                                                                <i class="fas fa-check-circle"></i>
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                {{-- Confirm Employee Modal --}}
                                                                <div class="modal fade" id="confirmEmployee{{$employee->id}}">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-success text-white">
                                                                                <h5 class="modal-title"><i class="fas fa-check-circle mr-2"></i>Confirm Employee</h5>
                                                                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <form action="{{url('employee/confirm/'.$employee->id)}}" method="post">
                                                                                @csrf
                                                                                <div class="modal-body text-center">
                                                                                    <img src="{{asset('images/print.gif')}}" alt="Processing..." class="img-fluid mb-3" style="max-height: 100px;">
                                                                                    <h6>Confirm {{ $employee->first_name }} {{ $employee->last_name }}?</h6>
                                                                                    <p class="text-muted">This will move the employee from probation to active status.</p>
                                                                                </div>
                                                                                <div class="modal-footer justify-content-center">
                                                                                    <button type="submit" name="dismiss" value="N" class="btn btn-outline-secondary">
                                                                                        <i class="fas fa-times mr-1"></i> Cancel
                                                                                    </button>
                                                                                    <button type="submit" name="confirm" value="Y" class="btn btn-success">
                                                                                        <i class="fas fa-check mr-1"></i> Confirm
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="text-center py-5">
                                                    <div class="empty-state">
                                                        <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">No Employees on Probation</h5>
                                                        <p class="text-muted">All employees are currently active</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Processing Loader --}}
                        <div id="processing" class="text-center py-3" style="display: none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="text-muted mt-2">Refreshing data...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px 10px 0 0;
        }
        
        .nav-pills .nav-link.active {
            background-color: #667eea;
            color: white;
            border-radius: 6px;
        }
        
        .nav-pills .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .nav-pills .nav-link:hover {
            background-color: #f8f9fa;
        }
        
        .avatar {
            font-size: 14px;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.4em 0.6em;
        }
        
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .alert-success {
            border-left-color: #28a745;
        }
        
        .alert-danger {
            border-left-color: #dc3545;
        }
        
        .empty-state {
            padding: 2rem 1rem;
        }
        
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0 0;
        }
        
        .custom-file-label::after {
            content: "Browse";
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize DataTables
            $('#activeEmployeesTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search active employees...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries available",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                }
            });

            $('#probationEmployeesTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search probation employees...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries available",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                }
            });

            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Custom file input
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Refresh functionality
            document.getElementById('refresh').addEventListener('click', (event) => {
                event.preventDefault();
                $('#processing').show();
                
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
@stop