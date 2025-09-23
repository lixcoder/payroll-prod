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
                                            <h5 class="mb-0"><i class="feather icon-plus-circle mr-2 text-primary"></i>New Relief</h5>
                                            <small class="text-muted">Create a new tax relief type</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a class="btn btn-outline-secondary btn-sm" href="{{ URL::to('reliefs') }}">
                                                <i class="feather icon-arrow-left mr-1"></i> Back to List
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger alert-dismissible fade show">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <i class="feather icon-x-circle mr-2"></i>{{ $error }}
                                            </div>
                                        @endforeach
                                    @endif

                                    <form method="POST" action="{{ URL::to('reliefs') }}" accept-charset="UTF-8">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="form-label">Relief Name <span style="color:red">*</span></label>
                                            <input class="form-control" placeholder="Enter relief name" type="text" name="name" id="name" value="{{ old('name') }}">
                                        </div>

                                        <div class="form-actions form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="feather icon-check-circle mr-1"></i> Create Relief
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
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .form-label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .form-control {
            border-radius: 4px;
            padding: 8px 12px;
            border: 1px solid #dce1e6;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        .btn {
            border-radius: 4px;
            padding: 8px 16px;
            font-weight: 500;
        }
        
        .alert {
            border-radius: 4px;
            border: none;
            padding: 12px 16px;
        }
    </style>

    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
    </script>
@stop