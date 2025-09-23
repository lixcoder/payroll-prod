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
                                            <h5 class="mb-0"><i class="feather icon-pie-chart mr-2 text-primary"></i>Payroll Reports</h5>
                                            <small class="text-muted">Comprehensive payroll reporting system</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-primary">
                                                    <i class="feather icon-file-text"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Monthly Payslips</h6>
                                                    <p>Download monthly employee payslips</p>
                                                    <a href="{{ url('payrollReports/selectPeriod') }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-success">
                                                    <i class="feather icon-bar-chart"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Payroll Summary</h6>
                                                    <p>Comprehensive payroll summary reports</p>
                                                    <a href="{{ url('payrollReports/selectSummaryPeriod') }}" class="btn btn-outline-success btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-info">
                                                    <i class="feather icon-credit-card"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Pay Remittance</h6>
                                                    <p>Payment remittance reports</p>
                                                    <a href="{{ URL::to('payrollReports/selectRemittancePeriod') }}" class="btn btn-outline-info btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-warning">
                                                    <i class="feather icon-dollar-sign"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Earning Report</h6>
                                                    <p>Employee earnings reports</p>
                                                    <a href="{{ URL::to('payrollReports/selectEarning') }}" class="btn btn-outline-warning btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-danger">
                                                    <i class="feather icon-clock"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Overtime Report</h6>
                                                    <p>Overtime hours and payments</p>
                                                    <a href="{{ URL::to('payrollReports/selectOvertime') }}" class="btn btn-outline-danger btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-secondary">
                                                    <i class="feather icon-gift"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Allowance Report</h6>
                                                    <p>Employee allowance reports</p>
                                                    <a href="{{ URL::to('payrollReports/selectAllowance') }}" class="btn btn-outline-secondary btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-dark">
                                                    <i class="feather icon-percent"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Non Taxable Income</h6>
                                                    <p>Non-taxable income reports</p>
                                                    <a href="{{ URL::to('payrollReports/selectnontaxableincome') }}" class="btn btn-outline-dark btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-primary">
                                                    <i class="feather icon-users"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Pension Report</h6>
                                                    <p>Pension contribution reports</p>
                                                    <a href="{{ URL::to('payrollReports/selectPension') }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-success">
                                                    <i class="feather icon-shield"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Relief Report</h6>
                                                    <p>Tax relief reports</p>
                                                    <a href="{{ URL::to('payrollReports/selectRelief') }}" class="btn btn-outline-success btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-info">
                                                    <i class="feather icon-minus-circle"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Deduction Report</h6>
                                                    <p>Employee deduction reports</p>
                                                    <a href="{{ URL::to('payrollReports/selectDeduction') }}" class="btn btn-outline-info btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
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
        </div>
    </div>

    <style>
        .report-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .report-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 20px;
        }
        
        .report-content h6 {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .report-content p {
            color: #6c757d;
            font-size: 12px;
            margin-bottom: 15px;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 12px;
        }
    </style>
@stop