@extends('layouts.main_hr')
@section('xara_cbs')
    <?php
    function asMoney($value) {
        return number_format($value, 2);
    }
    ?>
    
    <style>
        :root {
            --primary: #6080c5ff;
            --secondary: #9333ea;
            --success: #10b981;
            --info: #bfcfd6ff;
            --warning: #f59e0b;
            --danger: #ef4444;
            --light: #9eb3c9ff;
            --dark: #111827;
        }

        
        .employee-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: none;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }
        
        .employee-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header-custom {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        
        .info-badge {
            background-color: var(--light);
            color: var(--dark);
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            display: inline-block;
            width: 100%;
        }
        
        .detail-item {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .nav-pills .nav-link {
            border-radius: 5px;
            margin-right: 5px;
            color: var(--dark);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 12px;
        }
        
        .nav-pills .nav-link.active {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
        }
        
        .tab-content {
            padding: 20px 0;
        }
        
        .table-custom {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
        }
        
        .table-custom th {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            font-weight: 600;
            padding: 12px 15px;
        }
        
        .table-custom td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        
        .employee-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .action-btn {
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .section-title {
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 1.25rem;
        }
        
        .icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            background-color: rgba(78, 115, 223, 0.1);
            color: var(--primary);
            flex-shrink: 0;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .data-table th {
            text-align: left;
            padding: 12px;
            background-color: #f8f9fc;
            font-weight: 600;
        }
        
        .data-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .data-table tr:last-child td {
            border-bottom: none;
        }
        
        .info-section {
            margin-bottom: 25px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .info-box {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .info-box-header {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-pills .nav-link {
                margin-bottom: 5px;
                font-size: 0.8rem;
            }
        }
    </style>
    
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (Session::has('flash_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i> {{ Session::get('flash_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (Session::has('delete_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i> {{ Session::get('delete_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            
                            <div class="d-flex mb-4 flex-wrap">
                                <a class="btn btn-primary action-btn me-2 mb-2" href="{{ url('employees/edit/'.$employee->id)}}">
                                    <i class="fas fa-edit me-2"></i>Update Details
                                </a>
                                <a class="btn btn-danger action-btn mb-2" href="{{url('employees/deactivate/'.$employee->id)}}"
                                   onclick="return confirm('Are you sure you want to deactivate this employee?')">
                                    <i class="fas fa-user-times me-2"></i>Deactivate
                                </a>
                            </div>
                            
                            <hr class="mb-4">
                        </div>
                        
                        <div class="col-md-3">
                            <div class="employee-card">
                                <div class="card-body text-center">
                                    @if($employee->photo =='https://via.placeholder.com/150C/O')
                                        <img class="employee-photo" src="https://via.placeholder.com/150C/O" alt="Employee Photo">
                                    @else
                                        <img class="employee-photo" src="{{asset('/public/uploads/employees/photo/'.$employee->photo) }}" alt="Employee Photo">
                                    @endif
                                    <h3 class="mt-3 text-primary">{{$employee->first_name.' '.$employee->last_name}}</h3>
                                    <p class="text-muted">{{$employee->personal_file_number}}</p>
                                </div>
                            </div>
                            
                            <div class="employee-card">
                                <div class="card-body">
                                    <div class="detail-item">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <strong>Email</strong>
                                            <p class="mb-0 text-muted">
                                                {{$employee->email_office.' / '.$employee->email_personal}}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div>
                                            <strong>Phone Number</strong>
                                            <p class="mb-0 text-muted">
                                                @if($employee->telephone_office == NULL||$employee->telephone_personal== NULL||$employee->extension_office== NULL)
                                                    N/A
                                                @else
                                                    {{$employee->telephone_office.' /'.$employee->telephone_personal.' /'.$employee->extension_office}}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-male"></i>
                                        </div>
                                        <div>
                                            <strong>Gender</strong>
                                            <p class="mb-0 text-muted">{{$employee->gender}}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-id-card"></i>
                                        </div>
                                        <div>
                                            <strong>Identity Number</strong>
                                            <p class="mb-0 text-muted">{{$employee->identity_number}}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-heart"></i>
                                        </div>
                                        <div>
                                            <strong>Marital Status</strong>
                                            <p class="mb-0 text-muted">
                                                @if($employee->marital_status != NULL)
                                                    {{$employee->marital_status}}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="detail-item">
                                        <div class="icon-wrapper">
                                            <i class="fas fa-birthday-cake"></i>
                                        </div>
                                        <div>
                                            <strong>Date Of Birth</strong>
                                            <p class="mb-0 text-muted">
                                                @if($employee->yob !=NULL)
                                                    {{$employee->yob}}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
<div class="detail-item">
    <div class="icon-wrapper"><i class="fas fa-flag"></i></div>
    <div>
        <strong>Citizenship</strong>
        <p class="mb-0 text-muted">
            {{ $employee->citizenship->name ?? 'N/A' }}
        </p>
    </div>
</div>
                                    
<div class="detail-item">
    <div class="icon-wrapper"><i class="fas fa-graduation-cap"></i></div>
    <div>
        <strong>Education</strong>
        <p class="mb-0 text-muted">
            {{ $employee->educationType->name ?? 'N/A' }}
        </p>
    </div>
</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <div class="employee-card">
                                <div class="card-header card-header-custom">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#activity" data-toggle="tab">
                                                <i class="fas fa-info-circle me-2"></i>Employee Information
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#timeline" data-toggle="tab">
                                                <i class="fas fa-users me-2"></i>Next Of Kin
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#settings" data-toggle="tab">
                                                <i class="fas fa-file me-2"></i>Documents
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#appraisals" data-toggle="tab">
                                                <i class="fas fa-chart-line me-2"></i>Appraisals
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#property" data-toggle="tab">
                                                <i class="fas fa-laptop me-2"></i>Company Property
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#occurrence" data-toggle="tab">
                                                <i class="fas fa-exclamation-triangle me-2"></i>Occurrence
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#benefit" data-toggle="tab">
                                                <i class="fas fa-gift me-2"></i>Benefits
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div id="activity" class="active tab-pane">
                                            <div class="info-section">
                                                <h4 class="section-title">Company Information</h4>
                                                <div class="info-grid">
                                                    <div class="info-box">
                                                        <div class="info-box-header">Branch</div>
                                                        <p>
                                                            @if($employee->branch_id != 0)
                                                                {{ $employee->branch->name}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Department</div>
                                                        <p>
                                                            @if($employee->department_id != 0)
                                                                {{ $employee->department->name.' ('.$employee->department->codes.')'}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Job Group</div>
                                                        <p>
                                                            @if($employee->job_group_id != 0)
                                                                <?php
                                                                $jgroup = DB::table('x_job_group')->where('id', '=', $employee->job_group_id)->pluck('job_group_name')->first();
                                                                ?>
                                                                {{ $jgroup}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Employee Type</div>
                                                        <p>
                                                            @if($employee->type_id != 0)
                                                                <?php
                                                                $etype = DB::table('x_employee_type')->where('id', '=', $employee->type_id)->pluck('employee_type_name')->first();
                                                                ?>
                                                                {{ $etype}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Work Permit</div>
                                                        <p>
                                                            @if($employee->work_permit_number != null)
                                                                {{$employee->work_permit_number}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Job Title</div>
                                                        <p>
                                                            @if($employee->job_title != null)
                                                                {{$employee->job_title}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Basic Salary</div>
                                                        <p>{{asMoney((double)$employee->basic_pay)}}</p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Date Joined</div>
                                                        <p>
                                                            @if($employee->date_joined != null)
                                                                {{date('d-M-Y',strtotime($employee->date_joined))}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Start Date</div>
                                                        <p>{{ $employee->start_date}}</p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">End Date</div>
                                                        <p>{{ $employee->end_date}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="info-section">
                                                <h4 class="section-title">Government Requirements</h4>
                                                <div class="info-grid">
                                                    <div class="info-box">
                                                        <div class="info-box-header">KRA Pin</div>
                                                        <p>
                                                            @if($employee->pin != null)
                                                                {{$employee->pin}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">NSSF Number</div>
                                                        <p>
                                                            @if($employee->social_security_number != null)
                                                                {{$employee->social_security_number}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">NHIF Number</div>
                                                        <p>
                                                            @if($employee->hospital_insurance_number != null)
                                                                {{$employee->hospital_insurance_number}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="info-section">
                                                <h4 class="section-title">Bank Information</h4>
                                                <div class="info-grid">
                                                    <div class="info-box">
                                                        <div class="info-box-header">Mode of Payment</div>
                                                        <p>
                                                            @if($employee->mode_of_payment == 'Others')
                                                                {{$employee->custom_field1}}
                                                            @else
                                                                {{$employee->mode_of_payment}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Bank</div>
                                                        <p>
                                                            @if($employee->bank_id != 0)
                                                                <?php
                                                                $bank = DB::table('banks')->where('id', '=', $employee->bank_id)->pluck('bank_name');
                                                                ?>
                                                                {{ $bank}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Bank Branch</div>
                                                        <p>
                                                            @if($employee->bank_id != 0)
                                                                <?php
                                                                $bbranch = DB::table('bank_branches')->where('id', '=', $employee->bank_branch_id)->pluck('bank_branch_name');
                                                                ?>
                                                                {{ $bbranch}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Bank Account Number</div>
                                                        <p>
                                                            @if($employee->bank_account_number != null)
                                                                {{$employee->bank_account_number}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Sort Code</div>
                                                        <p>
                                                            @if($employee->bank_eft_code != null)
                                                                {{$employee->bank_eft_code}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Swift Code</div>
                                                        <p>
                                                            @if($employee->swift_code != null)
                                                                {{$employee->swift_code}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="info-section">
                                                <h4 class="section-title">Contact Information</h4>
                                                <div class="info-grid">
                                                    <div class="info-box">
                                                        <div class="info-box-header">Office Email</div>
                                                        <p>
                                                            @if($employee->email_office != null)
                                                                {{$employee->email_office}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Personal Email</div>
                                                        <p>
                                                            @if($employee->email_personal != null)
                                                                {{$employee->email_personal}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Mobile Phone</div>
                                                        <p>
                                                            @if($employee->telephone_mobile != null)
                                                                {{$employee->telephone_mobile}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Postal Address</div>
                                                        <p>
                                                            @if($employee->postal_address != null)
                                                                {{$employee->postal_address}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Postal Zip</div>
                                                        <p>
                                                            @if($employee->postal_zip != null)
                                                                {{$employee->postal_zip}}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="info-section">
                                                <h4 class="section-title">Other Information</h4>
                                                <div class="info-grid">
                                                    <div class="info-box">
                                                        <div class="info-box-header">Apply Tax</div>
                                                        <p>
                                                            @if($employee->income_tax_applicable != null)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Apply Tax Relief</div>
                                                        <p>
                                                            @if($employee->income_tax_relief_applicable != null)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Apply NSSF</div>
                                                        <p>
                                                            @if($employee->hospital_insurance_applicable != null)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        </p>
                                                    </div>
                                                    
                                                    <div class="info-box">
                                                        <div class="info-box-header">Apply NHIF</div>
                                                        <p>
                                                            @if($employee->social_security_applicable != null)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Other tabs would follow the same improved pattern -->
                                        <div id="timeline" class="tab-pane">
                                            <div class="employee-card">
                                                <div class="card-body">
                                                    <h4 class="section-title">Next of Kin</h4>
                                                    <div class="table-responsive">
                                                        <table class="table table-custom table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Kin Name</th>
                                                                    <th>ID Number</th>
                                                                    <th>Relationship</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 1; ?>
                                                                @foreach($kins as $kin)
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $kin->kin_name ?: 'N/A' }}</td>
                                                                        <td>{{ $kin->id_number ?: 'N/A' }}</td>
                                                                        <td>{{ $kin->relation ?: 'N/A' }}</td>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <a href="{{URL::to('NextOfKins/view/'.$kin->id)}}" class="btn btn-sm btn-info">
                                                                                    <i class="fas fa-eye"></i>
                                                                                </a>
                                                                                <a href="{{URL::to('NextOfKins/delete/'.$kin->id)}}" 
                                                                                   class="btn btn-sm btn-danger"
                                                                                   onclick="return confirm('Are you sure you want to delete this employee\'s kin?')">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Remaining tabs would follow the same pattern -->
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection