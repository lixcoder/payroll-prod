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
                                            <h5 class="mb-0"><i class="feather icon-edit mr-2 text-primary"></i>Update Deduction</h5>
                                            <small class="text-muted">Modify deduction details</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a class="btn btn-outline-secondary btn-sm" href="{{ URL::to('deductions') }}">
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

                                    <form method="POST" action="{{ URL::to('deductions/update/'.$deduction->id) }}" accept-charset="UTF-8">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name" class="form-label">Deduction Name <span style="color:red">*</span></label>
                                            <input class="form-control" placeholder="Enter deduction name" type="text" name="name" id="name" value="{{ $deduction->deduction_name }}">
                                        </div>

                                        <div class="form-actions form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="feather icon-check-circle mr-1"></i> Update Deduction
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