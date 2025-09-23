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
                                                <i class="feather icon-gift mr-2 text-primary"></i>
                                                Allowances Management
                                            </h5>
                                            <small class="text-muted">
                                                Manage employee allowances and benefits
                                            </small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('allowances/create')}}" class="btn btn-primary btn-sm">
                                                <i class="feather icon-plus mr-1"></i>
                                                New Allowance
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Alert Messages -->
                                    @if (Session::has('success_message'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i>
                                            {{ Session::get('success_message') }}
                                        </div>
                                    @endif

                                    @if (Session::has('delete_message'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-alert-triangle mr-2"></i>
                                            {{ Session::get('delete_message') }}
                                        </div>
                                    @endif

                                    <!-- Allowances Table -->
                                    <div class="table-responsive">
                                        <table id="allowancesTable" class="table table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Allowance Name</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($allowances as $allowance)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="icon-circle bg-warning text-white mr-3">
                                                                    <i class="feather icon-gift"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $allowance->allowance_name }}</h6>
                                                                    <small class="text-muted">ID: {{ $allowance->id }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success">Active</span>
                                                        </td>
                                                        <td>{{ date('M d, Y', strtotime($allowance->created_at)) }}</td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{URL::to('allowances/edit/'.$allowance->id)}}" 
                                                                   class="btn btn-outline-primary btn-sm" 
                                                                   data-toggle="tooltip" 
                                                                   title="Edit Allowance">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{URL::to('allowances/delete/'.$allowance->id)}}" 
                                                                   class="btn btn-outline-danger btn-sm" 
                                                                   data-toggle="tooltip" 
                                                                   title="Delete Allowance"
                                                                   onclick="return confirm('Are you sure you want to delete this allowance?')">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($allowances->isEmpty())
                                        <div class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">
                                                    <i class="feather icon-gift"></i>
                                                </div>
                                                <h4>No Allowances Found</h4>
                                                <p class="text-muted">Get started by creating your first allowance.</p>
                                                <a href="{{ URL::to('allowances/create') }}" class="btn btn-primary">
                                                    <i class="feather icon-plus mr-1"></i>
                                                    Create Allowance
                                                </a>
                                            </div>
                                        </div>
                                    @endif
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
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
            border-color: #f1f1f1;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(59, 125, 221, 0.05);
            transform: translateY(-1px);
            transition: all 0.3s ease;
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
        
        .btn-primary {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2a5298 0%, #1e3c72 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .btn-outline-primary, .btn-outline-danger {
            border-width: 1px;
            margin: 0 2px;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 15px;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }
        
        .empty-state-icon {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
        
        .empty-state h4 {
            color: #495057;
            margin-bottom: 0.5rem;
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
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn-group .btn {
                margin: 2px 0;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Initialize DataTable
            $('#allowancesTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search allowances...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                },
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                columnDefs: [
                    { orderable: false, targets: [4] }
                ]
            });
            
            // Fade out alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
        });
    </script>
@stop