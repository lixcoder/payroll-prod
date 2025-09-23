@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <!-- Card Header -->
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0">
                                                <i class="feather icon-database mr-2 text-primary"></i>
                                                Data Migration Center
                                            </h5>
                                            <small class="text-muted">
                                                Import data from Excel templates to populate your system
                                            </small>
                                        </div>
                                        <div class="card-header-right">
                                            <button class="btn btn-outline-info btn-sm" data-toggle="collapse" data-target="#helpSection">
                                                <i class="feather icon-help-circle mr-1"></i>
                                                Migration Guide
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Help Section -->
                                <div id="helpSection" class="collapse">
                                    <div class="card-body bg-light border-bottom">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6><i class="feather icon-info mr-2 text-primary"></i>Migration Process</h6>
                                                <ol class="pl-3">
                                                    <li>Download the appropriate template for your data</li>
                                                    <li>Fill in the data following the template structure</li>
                                                    <li>Upload the completed Excel file using the form below</li>
                                                    <li>Review any validation messages after import</li>
                                                </ol>
                                            </div>
                                            <div class="col-md-6">
                                                <h6><i class="feather icon-alert-triangle mr-2 text-warning"></i>Important Notes</h6>
                                                <ul class="pl-3 mb-0">
                                                    <li>Ensure data follows the exact format in the template</li>
                                                    <li>Backup your data before performing migrations</li>
                                                    <li>Large files may take several minutes to process</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Alert Messages -->
                                    @if (Session::get('notice'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i>
                                            {{ Session::get('notice') }}
                                        </div>
                                    @endif

                                    @if (Session::has('delete_message'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-alert-triangle mr-2"></i>
                                            {{ Session::get('delete_message') }}
                                        </div>
                                    @endif

                                    <!-- Migration Sections -->
                                    <div class="row">
                                        <!-- Employees Migration -->
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card migration-card mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-primary text-white mr-3">
                                                            <i class="feather icon-users"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Employees Migration</h6>
                                                            <small class="text-muted">Import employee data</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <a href="{{URL::to('template/trialemployees')}}" class="btn btn-outline-primary btn-sm btn-block">
                                                            <i class="feather icon-download mr-1"></i>
                                                            Download Template
                                                        </a>
                                                    </div>
                                                    
                                                    <form method="post" action="{{URL::to('import/trialemployees')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="small font-weight-bold">Upload Employees (Excel)</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="trialemployees" name="trialemployees" accept=".xls,.xlsx">
                                                                <label class="custom-file-label" for="trialemployees">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                                                            <i class="feather icon-upload mr-1"></i>
                                                            Import Employees
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Earnings Migration -->
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card migration-card mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-success text-white mr-3">
                                                            <i class="feather icon-dollar-sign"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Earnings Migration</h6>
                                                            <small class="text-muted">Import earnings data</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <a href="{{URL::to('template/earnings')}}" class="btn btn-outline-success btn-sm btn-block">
                                                            <i class="feather icon-download mr-1"></i>
                                                            Download Template
                                                        </a>
                                                    </div>
                                                    
                                                    <form method="post" action="{{URL::to('import/earnings')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="small font-weight-bold">Upload Earnings (Excel)</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="earnings" name="earnings" accept=".xls,.xlsx">
                                                                <label class="custom-file-label" for="earnings">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-success btn-sm btn-block">
                                                            <i class="feather icon-upload mr-1"></i>
                                                            Import Earnings
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Allowances Migration -->
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card migration-card mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-warning text-white mr-3">
                                                            <i class="feather icon-gift"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Allowances Migration</h6>
                                                            <small class="text-muted">Import allowances data</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <a href="{{URL::to('template/allowances')}}" class="btn btn-outline-warning btn-sm btn-block">
                                                            <i class="feather icon-download mr-1"></i>
                                                            Download Template
                                                        </a>
                                                    </div>
                                                    
                                                    <form method="post" action="{{URL::to('import/allowances')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="small font-weight-bold">Upload Allowances (Excel)</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="allowances" name="allowances" accept=".xls,.xlsx">
                                                                <label class="custom-file-label" for="allowances">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-warning btn-sm btn-block">
                                                            <i class="feather icon-upload mr-1"></i>
                                                            Import Allowances
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Reliefs Migration -->
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card migration-card mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-info text-white mr-3">
                                                            <i class="feather icon-percent"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Reliefs Migration</h6>
                                                            <small class="text-muted">Import relief data</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <a href="{{URL::to('template/reliefs')}}" class="btn btn-outline-info btn-sm btn-block">
                                                            <i class="feather icon-download mr-1"></i>
                                                            Download Template
                                                        </a>
                                                    </div>
                                                    
                                                    <form method="post" action="{{URL::to('import/reliefs')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="small font-weight-bold">Upload Reliefs (Excel)</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="reliefs" name="reliefs" accept=".xls,.xlsx">
                                                                <label class="custom-file-label" for="reliefs">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-info btn-sm btn-block">
                                                            <i class="feather icon-upload mr-1"></i>
                                                            Import Reliefs
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Deductions Migration -->
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card migration-card mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-danger text-white mr-3">
                                                            <i class="feather icon-minus-circle"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Deductions Migration</h6>
                                                            <small class="text-muted">Import deductions data</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <a href="{{URL::to('template/deductions')}}" class="btn btn-outline-danger btn-sm btn-block">
                                                            <i class="feather icon-download mr-1"></i>
                                                            Download Template
                                                        </a>
                                                    </div>
                                                    
                                                    <form method="post" action="{{URL::to('import/deductions')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="small font-weight-bold">Upload Deductions (Excel)</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="deductions" name="deductions" accept=".xls,.xlsx">
                                                                <label class="custom-file-label" for="deductions">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger btn-sm btn-block">
                                                            <i class="feather icon-upload mr-1"></i>
                                                            Import Deductions
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pension Migration -->
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card migration-card mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-secondary text-white mr-3">
                                                            <i class="feather icon-credit-card"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Pension Migration</h6>
                                                            <small class="text-muted">Import pension data</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <a href="{{URL::to('template/employees')}}" class="btn btn-outline-secondary btn-sm btn-block">
                                                            <i class="feather icon-download mr-1"></i>
                                                            Download Template
                                                        </a>
                                                    </div>
                                                    
                                                    <form method="post" action="{{URL::to('import/employees')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="small font-weight-bold">Upload Pension (Excel)</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="pensions" name="pensions" accept=".xls,.xlsx">
                                                                <label class="custom-file-label" for="pensions">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-secondary btn-sm btn-block">
                                                            <i class="feather icon-upload mr-1"></i>
                                                            Import Pension
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bank Migration -->
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card migration-card mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-dark text-white mr-3">
                                                            <i class="feather icon-home"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Bank Migration</h6>
                                                            <small class="text-muted">Import bank data</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <a href="{{asset('/Excel/banks.xls') }}" class="btn btn-outline-dark btn-sm btn-block">
                                                            <i class="feather icon-download mr-1"></i>
                                                            Download Template
                                                        </a>
                                                    </div>
                                                    
                                                    <form method="post" action="{{URL::to('import/banks')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="small font-weight-bold">Upload Banks (Excel)</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="banks" name="banks" accept=".xls,.xlsx">
                                                                <label class="custom-file-label" for="banks">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-dark btn-sm btn-block">
                                                            <i class="feather icon-upload mr-1"></i>
                                                            Import Banks
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bank Branches Migration -->
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card migration-card mb-4">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="icon-circle bg-purple text-white mr-3">
                                                            <i class="feather icon-git-branch"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Bank Branches Migration</h6>
                                                            <small class="text-muted">Import branch data</small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <a href="{{asset('/Excel/bank_branches.xls') }}" class="btn btn-outline-purple btn-sm btn-block">
                                                            <i class="feather icon-download mr-1"></i>
                                                            Download Template
                                                        </a>
                                                    </div>
                                                    
                                                    <form method="post" action="{{URL::to('import/bankBranches')}}" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="small font-weight-bold">Upload Bank Branches (Excel)</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="bbranches" name="bbranches" accept=".xls,.xlsx">
                                                                <label class="custom-file-label" for="bbranches">Choose file</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-purple btn-sm btn-block">
                                                            <i class="feather icon-upload mr-1"></i>
                                                            Import Bank Branches
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
        </div>
    </div>

    <style>
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .migration-card {
            transition: all 0.3s ease;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .migration-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        
        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .custom-file-label::after {
            content: "Browse";
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .bg-purple {
            background-color: #6f42c1 !important;
        }
        
        .btn-purple {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: white;
        }
        
        .btn-outline-purple {
            color: #6f42c1;
            border-color: #6f42c1;
        }
        
        .btn-outline-purple:hover {
            background-color: #6f42c1;
            color: white;
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
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize file input labels
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
            
            // Fade out alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@endsection