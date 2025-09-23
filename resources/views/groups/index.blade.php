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
                                            <h5 class="mb-0"><i class="feather icon-users mr-2 text-primary"></i>Groups Management</h5>
                                            <small class="text-muted">Manage employee groups and their permissions</small>
                                        </div>
                                        <div class="card-header-right">
                                            <a href="{{ url('groups/create') }}" class="btn btn-primary btn-sm">
                                                <i class="feather icon-plus mr-1"></i> New Group
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- Notification Messages -->
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-check-circle mr-2"></i> {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="feather icon-alert-triangle mr-2"></i> {{ session('error') }}
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="groupsTable" class="table table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Group Name</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($groups as $index => $group)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="icon-circle bg-primary text-white mr-3">
                                                                    <i class="feather icon-users"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $group->name }}</h6>
                                                                    <small class="text-muted">ID: {{ $group->id }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ $group->description ?? 'No description provided' }}</td>
                                                        <td>
                                                            <span class="badge badge-success">Active</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('groups.edit', $group->id) }}" 
                                                                   class="btn btn-outline-primary btn-sm" 
                                                                   data-toggle="tooltip" 
                                                                   title="Edit Group">
                                                                    <i class="feather icon-edit"></i>
                                                                </a>
                                                                <a href="{{ route('groups.destroy', $group->id) }}" 
                                                                   class="btn btn-outline-danger btn-sm" 
                                                                   data-toggle="tooltip" 
                                                                   title="Delete Group"
                                                                   onclick="return confirm('Are you sure you want to delete this group?')">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="text-center py-5">
                                                                <div class="empty-state">
                                                                    <div class="empty-state-icon">
                                                                        <i class="feather icon-users"></i>
                                                                    </div>
                                                                    <h4>No Groups Found</h4>
                                                                    <p class="text-muted">Get started by creating your first employee group.</p>
                                                                    <a href="{{ url('groups/create') }}" class="btn btn-primary">
                                                                        <i class="feather icon-plus mr-1"></i> Create Group
                                                                    </a>
                                                                </div>
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
            
            .table-responsive {
                border-radius: 8px;
                border: 1px solid #f1f1f1;
            }
        }
        
        /* Animation for table rows */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        tbody tr {
            animation: fadeIn 0.5s ease-out;
        }
        
        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Initialize DataTable
            $('#groupsTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search groups...",
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
@endsection