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
                                            <h5 class="mb-0"><i class="feather icon-plus-circle mr-2 text-primary"></i>Assign Court Order to Employee</h5>
                                            <small class="text-muted">Create a new court order assignment</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ url('employee_court_orders') }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="feather icon-arrow-left mr-1"></i> Back to List
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-x-circle mr-2"></i>
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ url('employee_court_orders') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="employee_id" class="form-label">Employee <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="employee_id" id="employee_id" required>
                                                        <option value="">Select Employee</option>
                                                        @foreach($employees as $employee)
                                                            <option value="{{ $employee->id }}">
                                                                {{ $employee->personal_file_number }} - {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="court_order_id" class="form-label">Court Order <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="court_order_id" id="court_order_id" required>
                                                        <option value="">Select Court Order</option>
                                                        @foreach($courtOrders as $co)
                                                            <option value="{{ $co->id }}">{{ $co->order_number }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="date" name="start_date" id="start_date" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date" class="form-label">End Date</label>
                                                    <input class="form-control" type="date" name="end_date" id="end_date">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="max_deduction" class="form-label">Maximum Deduction (Optional)</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">{{ $currency->shortname ?? 'KES' }}</span>
                                                <input class="form-control" type="number" step="0.01" name="max_deduction" id="max_deduction" placeholder="0.00">
                                            </div>
                                            <small class="form-text text-muted">Maximum amount to deduct if order is percentage-based</small>
                                        </div>

                                        <div class="form-actions form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="feather icon-check-circle mr-1"></i> Save Assignment
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
        
        .input-group-addon {
            background-color: #f8f9fa;
            border: 1px solid #dce1e6;
            color: #6c757d;
            padding: 8px 12px;
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