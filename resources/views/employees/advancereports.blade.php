@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    
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
                                            <h5 class="mb-0"><i class="feather icon-file-text mr-2 text-primary"></i>Advance Reports</h5>
                                            <small class="text-muted">Download various advance-related reports</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-primary">
                                                    <i class="feather icon-bar-chart-2"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Advance Summary</h6>
                                                    <p>Download comprehensive advance summary reports</p>
                                                    <a href="{{ URL::to('advanceReports/selectSummaryPeriod') }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-success">
                                                    <i class="feather icon-credit-card"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Advance Remittance</h6>
                                                    <p>Download advance remittance reports</p>
                                                    <a href="{{ URL::to('advanceReports/selectRemittancePeriod') }}" class="btn btn-outline-success btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-info">
                                                    <i class="feather icon-file"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Blank Report Template</h6>
                                                    <p>Download blank report templates</p>
                                                    <a href="reports/blank" target="_blank" class="btn btn-outline-info btn-sm">
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
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .report-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            height: 100%;
            transition: transform 0.3s ease;
        }
        
        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .report-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: white;
            font-size: 24px;
        }
        
        .report-content h6 {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .report-content p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
@stop