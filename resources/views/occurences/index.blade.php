@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0"><i class="feather icon-alert-triangle mr-2 text-primary"></i>Employee Occurrences</h5>
                                    <small class="text-muted">Manage employee occurrence records</small>
                                </div>
                                <div class="card-header-right">
                                    <a href="{{ url('occurences/create')}}" class="btn btn-primary btn-sm">
                                        <i class="feather icon-plus mr-1"></i> New Occurrence
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
                                <table id="occurrences-table" class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Occurrence</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @forelse($occurences as $occurence)
                                            <tr>
                                                <td class="text-muted">{{ $i }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-light-primary rounded-circle mr-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                        <div>
                                                            @if($occurence->middle_name == null || $occurence->middle_name == '')
                                                                {{ $occurence->first_name.' '.$occurence->last_name }}
                                                            @else
                                                                {{ $occurence->first_name.' '.$occurence->middle_name.' '.$occurence->last_name }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold text-dark">{{ $occurence->occurence_brief }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="feather icon-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item text-primary" href="{{url('occurences/view/'.$occurence->id)}}">
                                                                <i class="feather icon-eye mr-2"></i> View Details
                                                            </a>
                                                            @if($occurence->doc_path)
                                                                <a class="dropdown-item text-success" href="{{url('occurences/download/'.$occurence->id)}}">
                                                                    <i class="feather icon-download mr-2"></i> Download
                                                                </a>
                                                            @endif
                                                            <a class="dropdown-item text-warning" href="{{url('occurences/edit/'.$occurence->id)}}">
                                                                <i class="feather icon-edit mr-2"></i> Update
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="{{url('occurences/delete/'.$occurence->id)}}" 
                                                               onclick="return confirm('Are you sure you want to delete this employee occurrence?')">
                                                                <i class="feather icon-trash-2 mr-2"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <div class="empty-state">
                                                        <div class="empty-state-icon bg-light-primary">
                                                            <i class="feather icon-alert-triangle" style="font-size: 2.5rem; color: #7DA0B1;"></i>
                                                        </div>
                                                        <h4 class="mt-3">No Occurrences Found</h4>
                                                        <p class="text-muted">Get started by recording employee occurrences.</p>
                                                        <a href="{{ url('occurences/create')}}" class="btn btn-primary mt-3">
                                                            <i class="feather icon-plus mr-1"></i> Record First Occurrence
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
        
        .empty-state {
            padding: 2rem 0;
        }
        
        .empty-state-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
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
        
        #occurrences-table {
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