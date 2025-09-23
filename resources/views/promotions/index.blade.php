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
                                            <h5 class="mb-0"><i class="feather icon-trending-up mr-2 text-primary"></i>Employee Promotions & Transfers</h5>
                                            <small class="text-muted">Manage employee career progression and movements</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ URL::to('promotions/create')}}" class="btn btn-primary btn-sm">
                                                <i class="feather icon-plus mr-1"></i> New Promotion/Transfer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <!-- Notifications -->
                                    @if (Session::has('flash_message'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i> {{ Session::get('flash_message') }}
                                        </div>
                                    @endif

                                    @if (Session::has('delete_message'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-x-circle mr-2"></i> {{ Session::get('delete_message') }}
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="promotions-table" class="table table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employee</th>
                                                    <th>Reason</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach($promotions as $promotion)
                                                    <tr>
                                                        <td class="text-muted">{{ $i }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-light-primary rounded-circle mr-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                                    <i class="feather icon-user"></i>
                                                                </div>
                                                                <div>
                                                                    <span class="font-weight-bold">{{ App\models\Promotion::getEmployee($promotion->employee_id) }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-dark">{{ $promotion->reason }}</span>
                                                        </td>
                                                        <td>
                                                            @if($promotion->type == 'promote')
                                                                <span class="badge badge-success">Promotion</span>
                                                            @else
                                                                <span class="badge badge-info">Transfer</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">{{ date('M d, Y', strtotime($promotion->date)) }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="feather icon-settings"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item text-primary" href="{{URL::to('promotions/show/'.$promotion->id)}}">
                                                                        <i class="feather icon-eye mr-2"></i> View Details
                                                                    </a>
                                                                    <a class="dropdown-item text-warning" href="{{URL::to('promotions/edit/'.$promotion->id)}}">
                                                                        <i class="feather icon-edit mr-2"></i> Update
                                                                    </a>
                                                                    @if($promotion->type == 'promote')
                                                                        <a class="dropdown-item text-success" href="{{URL::to('promotions/letters/'.$promotion->id)}}">
                                                                            <i class="feather icon-file-text mr-2"></i> Generate Letter
                                                                        </a>
                                                                    @else
                                                                        <a class="dropdown-item text-success" href="{{URL::to('transfer/letters/'.$promotion->id)}}">
                                                                            <i class="feather icon-file-text mr-2"></i> Generate Letter
                                                                        </a>
                                                                    @endif
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-danger" href="{{URL::to('promotions/delete/'.$promotion->id)}}" 
                                                                       onclick="return confirm('Are you sure you want to delete this employee {{$promotion->type}}?')">
                                                                        <i class="feather icon-trash-2 mr-2"></i> Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
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
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
            padding: 1rem 0.75rem;
        }
        
        .avatar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
            border-radius: 12px;
        }
        
        .btn-group .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-size: 0.9rem;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(30, 60, 114, 0.04);
            transform: translateY(-1px);
            transition: all 0.3s ease;
        }
        
        #promotions-table {
            border-radius: 8px;
            overflow: hidden;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
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
            }
            
            .table td, .table th {
                padding: 0.75rem 0.5rem;
            }
            
            .badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.5rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth animations
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 100);
            });
            
            // Initialize DataTable if needed
            if (typeof $.fn.DataTable !== 'undefined') {
                $('#promotions-table').DataTable({
                    responsive: true,
                    ordering: true,
                    searching: true,
                    pageLength: 10,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search records..."
                    }
                });
            }
        });
    </script>
@endsection