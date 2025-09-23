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
                                            <h5 class="mb-0"><i class="feather icon-message-square mr-2 text-primary"></i>SMS Notifications</h5>
                                            <small class="text-muted">Manage payroll SMS notifications to clients</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    <h6 class="mb-0"><i class="feather icon-edit-2 mr-2"></i>SMS Template</h6>
                                                </div>
                                                <div class="card-body">
                                                    <form method="post" action="{{ route('sms') }}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="text" class="form-label">SMS Message Template</label>
                                                            <textarea id="text" name="text" class="form-control" rows="5" 
                                                                      placeholder="Enter your SMS message template here">{{ $smsdata->smsdetails ?? '' }}</textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="feather icon-save mr-1"></i> Update SMS Template
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="mb-0"><i class="feather icon-users mr-2"></i>Employee Contacts</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Employee Name</th>
                                                                    <th>Phone Number</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>David</td>
                                                                    <td>0746717753</td>
                                                                    <td>
                                                                        <a href="#" class="btn btn-outline-primary btn-sm">
                                                                            <i class="feather icon-send mr-1"></i> Send SMS
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <!-- Add more employee rows as needed -->
                                                            </tbody>
                                                        </table>
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
    </div>

    <style>
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
        
        .form-label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #2c3e50;
            background-color: #f8f9fa;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 12px;
        }
    </style>
@endsection