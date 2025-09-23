@extends('layouts.main_hr')

@section('xara_cbs')
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <!-- Card Header -->
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0">
                                            <i class="feather icon-plus-circle mr-2 text-primary"></i>
                                            Create New Account
                                        </h5>
                                        <small class="text-muted">
                                            Add a new account to your chart of accounts
                                        </small>
                                    </div>
                                    <div class="card-header-right">
                                        <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm">
                                            <i class="feather icon-arrow-left mr-1"></i> Back
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Error Messages -->
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="feather icon-alert-triangle mr-2"></i>
                                        <strong>Please fix the following errors:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Success Message -->
                                @if (Session::has('success_message'))
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <i class="feather icon-check-circle mr-2"></i>
                                        {{ Session::get('success_message') }}
                                    </div>
                                @endif

                                <!-- Form -->
                                <form method="POST" action="{{ url('accounts') }}" class="needs-validation" novalidate>
                                    @csrf
                                    
                                    <div class="row">
                                        <!-- Account Category -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category" class="form-label">
                                                    <i class="feather icon-folder mr-1 text-primary"></i>
                                                    Account Category *
                                                </label>
                                                <select class="form-control select2" name="category" id="category" required>
                                                    <option value="">Select Category</option>
                                                    <option value="ASSET" {{ old('category') == 'ASSET' ? 'selected' : '' }}>
                                                        Asset (1000)
                                                    </option>
                                                    <option value="INCOME" {{ old('category') == 'INCOME' ? 'selected' : '' }}>
                                                        Income (2000)
                                                    </option>
                                                    <option value="EXPENSE" {{ old('category') == 'EXPENSE' ? 'selected' : '' }}>
                                                        Expense (3000)
                                                    </option>
                                                    <option value="EQUITY" {{ old('category') == 'EQUITY' ? 'selected' : '' }}>
                                                        Equity (4000)
                                                    </option>
                                                    <option value="LIABILITY" {{ old('category') == 'LIABILITY' ? 'selected' : '' }}>
                                                        Liability (5000)
                                                    </option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select an account category.
                                                </div>
                                            </div>
                                        </div>

                                        <!-- GL Code -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="code" class="form-label">
                                                    <i class="feather icon-hash mr-1 text-primary"></i>
                                                    GL Code *
                                                </label>
                                                <input type="text" class="form-control" name="code" id="code" 
                                                       value="{{ old('code') }}" placeholder="Enter GL code" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid GL code.
                                                </div>
                                                <small class="form-text text-muted">
                                                    Unique identifier for the account
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Name -->
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            <i class="feather icon-edit-2 mr-1 text-primary"></i>
                                            Account Name *
                                        </label>
                                        <input type="text" class="form-control" name="name" id="name" 
                                               value="{{ old('name') }}" placeholder="Enter account name" required>
                                        <div class="invalid-feedback">
                                            Please provide an account name.
                                        </div>
                                    </div>

                                    <!-- Active Status -->
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="active" 
                                                   id="active" value="1" {{ old('active') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="active">
                                                <i class="feather icon-power mr-1 text-success"></i>
                                                Active Account
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            Enable this to make the account active immediately
                                        </small>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather icon-save mr-1"></i>
                                            Create Account
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary ml-2">
                                            <i class="feather icon-refresh-cw mr-1"></i>
                                            Reset
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

    <style>
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 0.2rem rgba(30, 60, 114, 0.25);
        }
        
        .custom-switch .custom-control-label::before {
            border-radius: 12px;
        }
        
        .custom-switch .custom-control-label::after {
            border-radius: 50%;
        }
        
        .btn {
            border-radius: 6px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .select2-container--default .select2-selection--single {
            border-radius: 6px;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
        }
        
        .invalid-feedback {
            display: block;
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
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select Category",
                allowClear: true
            });
            
            // Form validation
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
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