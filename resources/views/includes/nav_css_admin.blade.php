<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            <div class="divider"></div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="">
                    <a href="{{ url('home')}}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                        <span class="pcoded-mtext">Human Resource</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Attendance/Timesheet</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('timesheet/attendances') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Attendance</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('timesheet/work_shift') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Timesheet</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ url('Properties') }}" class="waves-effect waves-dark">
                                <span class="pcoded-mtext">Company Property</span>
                            </a>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                <span class="pcoded-mtext">Employees Management</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="active">
                                    <a href="{{ url('employees') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employees</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('Appraisals') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Appraisals</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('occurences') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Occurrence</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ route('court_orders.index') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Court Orders</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('deactives') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employees Exits</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_promotion') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Promote/Transfer Employee</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('EmployeeForm') }}" target="_blank" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Detail Form</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('payrollReports/selectPeriod') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Payslips</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                                <span class="pcoded-mtext">General Settings</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('benefitsettings') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Benefits Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('employee_type') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Employee Types</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('job_group') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Job Groups</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('occurencesettings') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Occurrence Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('departments')}}">
                                        <span class="pcoded-mtext">Departments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('citizenships')}}">
                                        <span class="pcoded-mtext">Citizenship's</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('appraisalcategories') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Appraisal Category</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('AppraisalSettings') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Appraisal Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                                <span class="pcoded-mtext">Leave Management</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('leavemgmt')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-file"></i></span>
                                        <span class="pcoded-mtext">Leave Applications</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('leaveamends')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                        <span class="pcoded-mtext">Leaves Amended</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('leaveapprovals')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-check-circle"></i></span>
                                        <span class="pcoded-mtext">Leaves Approved</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('leaverejects')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-x-circle"></i></span>
                                        <span class="pcoded-mtext">Leaves Rejected</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('leavetypes')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                                        <span class="pcoded-mtext">Leave Types</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('holidays')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                                        <span class="pcoded-mtext">Holiday Management</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-globe"></i></span>
                                <span class="pcoded-mtext">Organization Management</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li>
                                    <a href="{{ url('organizations') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Organization</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('branches') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Branches</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('currencies') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Currency</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('departments')}}">
                                        <span class="pcoded-mtext">Departments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('banks') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Banks</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('bankbranches') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Bank Branches</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('overtime_settings') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Overtime Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('probation') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Probation Settings</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                        <span class="pcoded-mtext">Payroll Management</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-dollar-sign"></i></span>
                                <span class="pcoded-mtext">Payroll</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('other_earnings')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Earnings</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_allowances')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Allowances</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{(url('overtimes'))}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Overtime</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_deductions')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Deduction</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('import_repayments') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Pension</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_relief') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Relief</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employee_court_orders') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Court Orders</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('employeenontaxables') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Non-Taxable Income</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('payrollcalculator') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Payroll Calculator</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('email/payslip') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Email Payslip</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-refresh-cw"></i></span>
                                <span class="pcoded-mtext">Process Payroll</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('advance')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Advance Salaries</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('payroll')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Payroll</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('unlockpayroll/index')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Approve Payroll Rerun</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-bar-chart"></i></span>
                                <span class="pcoded-mtext">Reports</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('advanceReports')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Advance Reports</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('payrollReports')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Payroll Reports</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('statutoryReports')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Statutory Reports</span>
                                    </a>
                                </li>
                                 <li class="">
                                    <a href="{{ url('sms')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">SMS</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-sliders"></i></span>
                                <span class="pcoded-mtext">Preferences</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('accounts')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Accounts Settings</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('migrate')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Data Migration</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="pcoded-hasmenu">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-tool"></i></span>
                                <span class="pcoded-mtext">Payroll Settings</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="">
                                    <a href="{{ url('allowances')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Allowances</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('reliefs')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Relief</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('deductions')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Deductions</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('nssf')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">NSSF Rates</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('nhif')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">SHIF Rates</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('paye')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">PAYE Rates</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('housinglevy')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Housing Levy</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('personalrelief')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Personal Relief</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="{{ url('nontaxables')}}" class="waves-effect waves-dark">
                                        <span class="pcoded-mtext">Non Taxables</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="feather icon-cpu"></i></span>
                        <span class="pcoded-mtext">System</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li>
                            <a href="{{url('users')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                                <span class="pcoded-mtext">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('roles')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-shield"></i></span>
                                <span class="pcoded-mtext">Roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('audits')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-activity"></i></span>
                                <span class="pcoded-mtext">Audit</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url('audits')}}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="feather icon-mail"></i></span>
                                <span class="pcoded-mtext">Email Configuration</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->

<style>
    /* Modern professional navigation styling */
    .pcoded-navbar {
        background: linear-gradient(145deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
    }
    
    /* Main menu items */
    .pcoded-navbar .pcoded-item > li > a {
        color: rgba(255, 255, 255, 0.85);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 12px 20px;
        transition: all 0.3s ease;
        position: relative;
    }
    
    /* Hover and active states for main items */
    .pcoded-navbar .pcoded-item > li > a:hover,
    .pcoded-navbar .pcoded-item > li.pcoded-trigger > a {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.15), rgba(41, 128, 185, 0.15));
        color: #ffffff;
        transform: translateX(3px);
        border-left: 3px solid #3498db;
    }
    
    /* Submenu styling */
    .pcoded-navbar .pcoded-submenu {
        background: rgba(44, 62, 80, 0.8);
        backdrop-filter: blur(10px);
        border-left: 2px solid rgba(52, 152, 219, 0.3);
    }
    
    .pcoded-navbar .pcoded-submenu li a {
        color: rgba(255, 255, 255, 0.75);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        padding: 10px 25px;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .pcoded-navbar .pcoded-submenu li a:hover {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(41, 128, 185, 0.1));
        color: #ffffff;
        padding-left: 30px;
    }
    
    /* Nested submenu styling */
    .pcoded-navbar .pcoded-submenu .pcoded-submenu {
        background: rgba(44, 62, 80, 0.9);
        border-left: 2px solid rgba(52, 152, 219, 0.4);
    }
    
    .pcoded-navbar .pcoded-submenu .pcoded-submenu li a {
        color: rgba(255, 255, 255, 0.7);
        padding-left: 35px;
    }
    
    .pcoded-navbar .pcoded-submenu .pcoded-submenu li a:hover {
        color: #ffffff;
        padding-left: 40px;
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.08), rgba(41, 128, 185, 0.08));
    }
    
    /* Icon styling */
    .pcoded-navbar .pcoded-micon {
        color: rgba(255, 255, 255, 0.6);
        margin-right: 10px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .pcoded-navbar .pcoded-item > li > a:hover .pcoded-micon,
    .pcoded-navbar .pcoded-item > li.pcoded-trigger > a .pcoded-micon {
        color: #3498db;
        transform: scale(1.1);
    }
    
    /* Divider styling */
    .pcoded-navbar .divider {
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        height: 1px;
        margin: 10px 20px;
    }
    
    /* Active state styling */
    .pcoded-navbar .pcoded-item > li.active > a,
    .pcoded-navbar .pcoded-submenu > li.active > a {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(41, 128, 185, 0.2));
        color: #ffffff;
        border-left: 4px solid #3498db;
        box-shadow: 0 2px 10px rgba(52, 152, 219, 0.2);
    }
    
    .pcoded-navbar .pcoded-item > li.active > a .pcoded-micon {
        color: #3498db;
    }
    
    /* Special styling for payroll section */
    .pcoded-navbar .pcoded-item > li:nth-child(3) > a {
        position: relative;
    }
    
    .pcoded-navbar .pcoded-item > li:nth-child(3) > a:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #27ae60, #2ecc71);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .pcoded-navbar .pcoded-item > li:nth-child(3) > a:hover:before,
    .pcoded-navbar .pcoded-item > li:nth-child(3).pcoded-trigger > a:before {
        opacity: 1;
    }
    
    /* Scrollbar styling for navigation */
    .pcoded-navbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .pcoded-navbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }
    
    .pcoded-navbar::-webkit-scrollbar-thumb {
        background: rgba(52, 152, 219, 0.5);
        border-radius: 3px;
    }
    
    .pcoded-navbar::-webkit-scrollbar-thumb:hover {
        background: rgba(52, 152, 219, 0.7);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .pcoded-navbar .pcoded-item > li > a {
            padding: 10px 15px;
        }
        
        .pcoded-navbar .pcoded-submenu li a {
            padding: 8px 20px;
        }
        
        .pcoded-navbar .pcoded-submenu .pcoded-submenu li a {
            padding-left: 30px;
        }
    }
    
    /* Animation for menu expansion */
    .pcoded-navbar .pcoded-submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    
    .pcoded-navbar .pcoded-hasmenu.pcoded-trigger > .pcoded-submenu {
        max-height: 1000px;
        transition: max-height 0.5s ease-in;
    }
</style>