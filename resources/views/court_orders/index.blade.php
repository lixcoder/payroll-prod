@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0"><i class="feather icon-file-text mr-2 text-primary"></i>Court Orders</h5>
                                    <small class="text-muted">Manage employee court order records</small>
                                </div>
                                <div class="card-header-right">
                                    <a href="{{ url('court_orders/create') }}" class="btn btn-primary btn-sm">
                                        <i class="feather icon-plus mr-1"></i> New Court Order
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
                                <table id="court-orders-table" class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Order Number</th>
                                            <th>Order Type</th>
                                            <th class="text-right">Amount</th>
                                            <th class="text-center">Percentage</th>
                                            <th>Effective Date</th>
                                            <th>End Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($court_orders as $order)
                                            <tr>
                                                <td class="text-muted">{{ $i }}</td>
                                                <td>
                                                    <span class="font-weight-bold text-primary">{{ $order->order_number }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $order->order_type }}</span>
                                                </td>
                                                <td class="text-right">
                                                    <span class="font-weight-bold text-success">
                                                        {{ number_format($order->amount, 2) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($order->percentage)
                                                        <span class="badge badge-warning">{{ $order->percentage }}%</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ date('M d, Y', strtotime($order->effective_date)) }}</span>
                                                </td>
                                                <td>
                                                    @if($order->end_date)
                                                        <span class="text-muted">{{ date('M d, Y', strtotime($order->end_date)) }}</span>
                                                    @else
                                                        <span class="badge badge-success">Ongoing</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($order->end_date && strtotime($order->end_date) < time())
                                                        <span class="badge badge-secondary">Completed</span>
                                                    @else
                                                        <span class="badge badge-primary">Active</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="feather icon-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item text-warning" href="{{ url('court_orders/edit/'.$order->id) }}">
                                                                <i class="feather icon-edit mr-2"></i> Update
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="{{ url('court_orders/delete/'.$order->id) }}" 
                                                               onclick="return confirm('Are you sure you want to delete this court order?')">
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
                    <!-- [ page content ] end -->
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
        
        #court-orders-table {
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
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop