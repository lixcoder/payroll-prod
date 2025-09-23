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
                                                <i class="feather icon-percent mr-2 text-info"></i>
                                                NSSF Rates Management
                                            </h5>
                                            <small class="text-muted">
                                                Manage National Social Security Fund contribution rates
                                            </small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('nssf/create')}}" class="btn btn-info btn-sm">
                                                <i class="feather icon-plus mr-1"></i>
                                                New NSSF Rate
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

                                    <!-- NSSF Rates Table -->
                                    <div class="table-responsive">
                                        <table id="nssfTable" class="table table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Lower Limit</th>
                                                    <th>Upper Limit</th>
                                                    <th>Tier 1 Rate</th>
                                                    <th>Tier 2 Rate</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($nrates as $nrate)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <span class="font-weight-bold text-primary">
                                                                {{ number_format($nrate->lower_earnings_limit, 2) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-bold text-primary">
                                                                {{ number_format($nrate->upper_earnings_limit, 2) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success">
                                                                {{ $nrate->rate_tier1 }}%
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-warning">
                                                                {{ $nrate->rate_tier2 }}%
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success">Active</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{URL::to('nssf/edit/'.$nrate->id)}}" 
                                                                   class="btn btn-outline-primary btn-sm" 
                                                                   data-toggle="tooltip" 
                                                                   title="Edit NSSF Rate">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{URL::to('nssf/delete/'.$nrate->id)}}" 
                                                                   class="btn btn-outline-danger btn-sm" 
                                                                   data-toggle="tooltip" 
                                                                   title="Delete NSSF Rate"
                                                                   onclick="return confirm('Are you sure you want to delete this NSSF rate?')">
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

                                    @if($nrates->isEmpty())
                                        <div class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">
                                                    <i class="feather icon-percent"></i>
                                                </div>
                                                <h4>No NSSF Rates Found</h4>
                                                <p class="text-muted">Get started by creating your first NSSF rate.</p>
                                                <a href="{{ URL::to('nssf/create') }}" class="btn btn-info">
                                                    <i class="feather icon-plus mr-1"></i>
                                                    Create NSSF Rate
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
            background-color: rgba(23, 162, 184, 0.05);
            transform: translateY(-1px);
            transition: all 0.3s ease;
        }
        
        .btn {
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
        }
        
        .btn-info:hover {
            background: linear-gradient(135deg, #138496 0%, #17a2b8 100%);
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
            $('#nssfTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search NSSF rates...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                },
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                columnDefs: [
                    { orderable: false, targets: [6] }
                ],
                order: [[0, 'asc']]
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