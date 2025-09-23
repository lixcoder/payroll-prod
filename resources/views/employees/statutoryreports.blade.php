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
                                            <h5 class="mb-0"><i class="feather icon-shield mr-2 text-primary"></i>Statutory Reports</h5>
                                            <small class="text-muted">Government compliance and statutory reports</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-primary">
                                                    <i class="feather icon-archive"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>NSSF Returns</h6>
                                                    <p>National Social Security Fund returns</p>
                                                    <a href="#" data-toggle="modal" data-target="#downloadNssfReport" class="btn btn-outline-primary btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-success">
                                                    <i class="feather icon-heart"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>NHIF Returns</h6>
                                                    <p>National Health Insurance Fund returns</p>
                                                    <a href="#" data-toggle="modal" data-target="#downloadNhifReports" class="btn btn-outline-success btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-info">
                                                    <i class="feather icon-percent"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>PAYE Returns</h6>
                                                    <p>Pay As You Earn tax returns</p>
                                                    <a href="#" data-toggle="modal" data-target="#downloadPayeReport" class="btn btn-outline-info btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-warning">
                                                    <i class="feather icon-file"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>P9 Form</h6>
                                                    <p>Employee tax deduction certificates</p>
                                                    <a href="#" data-toggle="modal" data-target="#downloadP9Form" class="btn btn-outline-warning btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-danger">
                                                    <i class="feather icon-layers"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Merge Statutory</h6>
                                                    <p>Combine multiple statutory reports</p>
                                                    <a href="{{ URL::to('mergeStatutory/selectPeriod') }}" class="btn btn-outline-danger btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-secondary">
                                                    <i class="feather icon-download-cloud"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>iTax Template</h6>
                                                    <p>Download iTax compliance templates</p>
                                                    <a href="{{ URL::to('itax/download') }}" class="btn btn-outline-secondary btn-sm">
                                                        <i class="feather icon-download mr-1"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="report-card">
                                                <div class="report-icon bg-dark">
                                                    <i class="feather icon-file-text"></i>
                                                </div>
                                                <div class="report-content">
                                                    <h6>Blank Template</h6>
                                                    <p>Download blank report templates</p>
                                                    <a href="reports/blank" target="_blank" class="btn btn-outline-dark btn-sm">
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

    <!-- NSSF Modal -->
    <div class="modal fade" id="downloadNssfReport" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="feather icon-archive mr-2 text-primary"></i>NSSF Returns</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ URL::to('payrollReports/nssfReturns') }}" accept-charset="UTF-8">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('images/payroll2.gif') }}" class="img-fluid rounded" alt="NSSF Report">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="period" class="form-label">Period <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                        </div>
                                        <input required class="form-control datepicker2" readonly placeholder="Select period" 
                                               type="text" name="period" id="period" value="{{ old('period') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="format" class="form-label">Download as <span class="text-danger">*</span></label>
                                    <select required name="format" class="form-control">
                                        <option value="">Select Format</option>
                                        <option value="excel">Excel</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="feather icon-download mr-1"></i> Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- NHIF Modal -->
    <div class="modal fade" id="downloadNhifReports" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="feather icon-heart mr-2 text-success"></i>NHIF Returns</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ URL::to('payrollReports/nhifReturns') }}" accept-charset="UTF-8">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('images/excel.gif') }}" class="img-fluid rounded" alt="NHIF Report">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="period" class="form-label">Period <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                        </div>
                                        <input required class="form-control datepicker2" readonly placeholder="Select period" 
                                               type="text" name="period" id="period" value="{{ old('period') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="format" class="form-label">Download as <span class="text-danger">*</span></label>
                                    <select required name="format" class="form-control">
                                        <option value="">Select Format</option>
                                        <option value="excel">Excel</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="feather icon-download mr-1"></i> Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PAYE Modal -->
    <div class="modal fade" id="downloadPayeReport" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="feather icon-percent mr-2 text-info"></i>PAYE Returns</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ URL::to('payrollReports/payeReturns') }}" accept-charset="UTF-8">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('images/print.gif') }}" class="img-fluid rounded" alt="PAYE Report">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="period" class="form-label">Period <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                        </div>
                                        <input required class="form-control datepicker2" readonly placeholder="Select period" 
                                               type="text" name="period" id="period" value="{{ old('period') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Disabled Status <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-3">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="enabled" name="type" value="enabled" required>
                                            <label class="custom-control-label" for="enabled">No</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" id="disabled" name="type" value="disabled" required>
                                            <label class="custom-control-label" for="disabled">Yes</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="format" class="form-label">Download as <span class="text-danger">*</span></label>
                                    <select required name="format" class="form-control">
                                        <option value="">Select Format</option>
                                        <option value="excel">Excel</option>
                                        <option value="csv">CSV</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info">
                            <i class="feather icon-download mr-1"></i> Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- P9 Form Modal -->
    <div class="modal fade" id="downloadP9Form" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="feather icon-file mr-2 text-warning"></i>P9 Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ URL::to('payrollReports/p9form') }}" accept-charset="UTF-8">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('images/KRA.png') }}" class="img-fluid rounded" alt="P9 Form">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="period" class="form-label">Year <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="feather icon-calendar"></i></span>
                                        </div>
                                        <input required class="form-control year" placeholder="Select year" 
                                               type="text" name="period" id="period" value="{{ old('period') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="employeeid" class="form-label">Select Employee <span class="text-danger">*</span></label>
                                    <select name="employeeid" class="form-control" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            @if($employee->middle_name != null || $employee->middle_name != '')
                                                <option value="{{ $employee->id }}"> 
                                                    {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}
                                                </option>
                                            @else
                                                <option value="{{ $employee->id }}"> 
                                                    {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type" class="form-label">Format</label>
                                    <select id="type" class="form-control" name="type">
                                        <option>Excel</option>
                                        <option>Pdf</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="feather icon-download mr-1"></i> Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
    <script src="{{ asset('datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.datepicker2').datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
            
            $('.year').datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                endDate: '+0d',
                autoclose: true
            });
        });
    </script>

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
        
        .modal-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .custom-radio {
            margin-right: 15px;
        }
    </style>
@endsection