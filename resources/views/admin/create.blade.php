@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0">
                                                <i class="fas fa-user-plus mr-2 text-success"></i>
                                                Create New User
                                            </h5>
                                            <small class="text-muted">Add a new user to the system</small>
                                        </div>
                                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-arrow-left mr-1"></i> Back
                                        </a>
                                    </div>
                                </div>

                                @if(count($errors)>0)
                                    <div class="card-body pt-0">
                                        @foreach($errors->all() as $error)
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                                    <div><b>{{ $error }}</b></div>
                                                </div>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="card-body">
                                    <form action="{{ route('users.store') }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        @method('POST')
                                        
                                        <input type="hidden" name="organization_id" value="1">
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label font-weight-bold">Full Name <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light border-right-0">
                                                            <i class="fas fa-user text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           placeholder="John Doe" required>
                                                    <div class="invalid-feedback">Please provide user's full name.</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label font-weight-bold">Email Address <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light border-right-0">
                                                            <i class="fas fa-envelope text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <input type="email" class="form-control" id="email" name="email"
                                                           placeholder="john.doe@example.com" required>
                                                    <div class="invalid-feedback">Please provide a valid email address.</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="password" class="form-label font-weight-bold">Password <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light border-right-0">
                                                            <i class="fas fa-lock text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <input type="password" class="form-control" id="password"
                                                           name="password" placeholder="••••••••" required
                                                           pattern=".{8,}" title="Password must be at least 8 characters">
                                                    <div class="invalid-feedback">Password must be at least 8 characters.</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="confirm-password" class="form-label font-weight-bold">Confirm Password <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-light border-right-0">
                                                            <i class="fas fa-lock text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <input type="password" class="form-control" id="confirm-password"
                                                           name="confirm-password" placeholder="••••••••" required>
                                                    <div class="invalid-feedback">Passwords must match.</div>
                                                </div>
                                            </div>

                                            <div class="col-12 mb-4">
                                                <label class="form-label font-weight-bold">Roles <span class="text-danger">*</span></label>
                                                <div class="card">
                                                    <div class="card-body bg-light">
                                                        {!! Form::select('roles[]', $roles, [], [
                                                            'class' => 'form-control select2',
                                                            'multiple' => 'multiple',
                                                            'required' => 'required',
                                                            'data-placeholder' => 'Select roles...'
                                                        ]) !!}
                                                        <div class="invalid-feedback">Please select at least one role.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-success btn-lg px-5">
                                                <i class="fas fa-user-plus mr-2"></i>Create User
                                            </button>
                                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-lg ml-2 px-4">
                                                <i class="fas fa-times mr-2"></i>Cancel
                                            </a>
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
        .card-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 10px 10px 0 0;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
        }
        
        .form-control {
            border-radius: 0.375rem;
        }
        
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            min-height: 100px;
        }
        
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select roles...",
                allowClear: true,
                width: '100%'
            });

            // Password confirmation validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm-password');

            function validatePassword() {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Passwords must match');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }

            password.addEventListener('change', validatePassword);
            confirmPassword.addEventListener('keyup', validatePassword);

            // Form validation
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
@endsection