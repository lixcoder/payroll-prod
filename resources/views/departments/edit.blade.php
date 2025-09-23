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
                                            <h5 class="mb-0"><i class="feather icon-edit-2 mr-2 text-warning"></i>Update Department</h5>
                                            <small class="text-muted">Modify department information</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('departments') }}" class="btn btn-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i> Back to Departments
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <strong><i class="feather icon-alert-triangle mr-2"></i> Please fix the following errors:</strong>
                                            <ul class="mb-0 mt-2">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ URL::to('departments/update/'.$department->id) }}" class="modern-form">
                                        @csrf
                                        
                                        <div class="form-section mb-4">
                                            <h6 class="section-title bg-light p-3 border-bottom">
                                                <i class="feather icon-info mr-2 text-primary"></i>Department Information
                                            </h6>
                                            <div class="p-3">
                                                <div class="form-group">
                                                    <label for="code" class="font-weight-bold">Department Code <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light"><i class="feather icon-hash"></i></span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter department code" type="text" name="code" id="code" value="{{ $department->codes }}" required>
                                                    </div>
                                                    <small class="form-text text-muted">Enter a unique code for the department (e.g., DEPT001, HR, FIN, etc.)</small>
                                                </div>
                                                
                                                <div class="form-group mt-4">
                                                    <label for="name" class="font-weight-bold">Department Name <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-light"><i class="feather icon-layers"></i></span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter department name" type="text" name="name" id="name" value="{{ $department->name }}" required>
                                                    </div>
                                                    <small class="form-text text-muted">Enter the full name of the department (e.g., Human Resources, Finance, etc.)</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions text-right p-3 border-top">
                                            <button type="reset" class="btn btn-outline-secondary mr-2">
                                                <i class="feather icon-refresh-ccw mr-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="feather icon-save mr-1"></i> Update Department
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

    <style>
        .modern-form {
            background: #fff;
        }
        
        .card-header {
            background: linear-gradient(135deg, #fef9e7 0%, #f7dc6f 100%);
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
            padding: 10px 15px;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
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
        
        .btn-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border: none;
            color: white;
        }
        
        .btn-warning:hover {
            background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            color: white;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .form-text {
            color: #6c757d;
            font-size: 0.85rem;
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

    <script>
        $(document).ready(function() {
            // Form validation
            $('form').on('submit', function(e) {
                let isValid = true;
                
                // Check required fields
                $('[required]').each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    $('html, body').animate({
                        scrollTop: $('.is-invalid').first().offset().top - 100
                    }, 500);
                }
            });
            
            // Remove validation classes on input
            $('input').on('input', function() {
                $(this).removeClass('is-invalid');
            });
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@endsection