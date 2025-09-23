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
                                            <h5 class="mb-0">
                                                <i class="fas fa-users mr-2 text-primary"></i>
                                                User Management
                                            </h5>
                                            <small class="text-muted">Manage system users and their permissions</small>
                                        </div>
                                        <a href="{{ url('users/create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus mr-1"></i> Add New User
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    @if ($message = Session::get('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                <div>{{ $message }}</div>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                                <div>
                                                    @foreach ($errors->all() as $error)
                                                        {{ $error }}<br>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th class="border-0">#</th>
                                                    <th class="border-0">User</th>
                                                    <th class="border-0">Email</th>
                                                    <th class="border-0">Role</th>
                                                    <th class="border-0 text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($users as $user)
                                                    <tr class="user-row">
                                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                                        <td class="align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 font-weight-bold">{{ $user->name }}</h6>
                                                                    <small class="text-muted">ID: {{ $user->id }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">{{ $user->email }}</td>
                                                        <td class="align-middle">
                                                            @if (!empty($user->getRoleNames()))
                                                                @foreach ($user->getRoleNames() as $role)
                                                                    <span class="badge badge-primary">{{ $role }}</span>
                                                                @endforeach
                                                            @else
                                                                <span class="badge badge-secondary">No role assigned</span>
                                                            @endif
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-info" data-toggle="tooltip" title="View User">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right shadow">
                                                                    <a class="dropdown-item text-info" href="{{ route('users.show', $user->id) }}">
                                                                        <i class="fas fa-eye mr-2"></i>View Details
                                                                    </a>
                                                                    <a class="dropdown-item text-success" href="#" data-toggle="modal" data-target="#editUser{{ $user->id }}">
                                                                        <i class="fas fa-edit mr-2"></i>Edit User
                                                                    </a>
                                                                    <a class="dropdown-item text-warning" href="#" data-toggle="modal" data-target="#editUserPassword{{ $user->id }}">
                                                                        <i class="fas fa-key mr-2"></i>Update Password
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Edit User Modal -->
                                                    <div class="modal fade" id="editUser{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserLabel{{ $user->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h5 class="modal-title" id="editUserLabel{{ $user->id }}">
                                                                        <i class="fas fa-edit mr-2 text-primary"></i>
                                                                        Edit User: {{ $user->name }}
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST" action="{{ url('users/update',$user->id)}}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label class="form-label font-weight-bold">Name</label>
                                                                            <input type="text" name="name" class="form-control form-control-sm" value="{{ $user->name }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label font-weight-bold">Email</label>
                                                                            <input type="email" name="email" class="form-control form-control-sm" value="{{ $user->email }}">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label font-weight-bold" for="roles">Role</label>
                                                                            {!! Form::select('roles[]', $roles, $user->roles->pluck('name')->toArray(), array('class' => 'form-control form-control-sm select2','multiple')) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-primary btn-sm">Update User</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Update Password Modal -->
                                                    <div class="modal fade" id="editUserPassword{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="editUserPasswordLabel{{ $user->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-light">
                                                                    <h5 class="modal-title" id="editUserPasswordLabel{{ $user->id }}">
                                                                        <i class="fas fa-key mr-2 text-warning"></i>
                                                                        Update Password for {{ $user->name }}
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST" action="{{ url('users/update-password', $user->id) }}">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label class="form-label font-weight-bold">New Password</label>
                                                                            <input type="password" name="password" class="form-control form-control-sm" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="form-label font-weight-bold">Confirm Password</label>
                                                                            <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancel</button>
                                                                        <button class="btn btn-warning btn-sm" type="submit">
                                                                            Update Password
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                                <h5 class="text-muted">No Users Found</h5>
                                                                <p class="text-muted">Get started by adding your first user</p>
                                                                <a href="{{ url('users/create') }}" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-plus mr-1"></i> Add User
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if($users->hasPages())
                                        <div class="d-flex justify-content-center mt-4">
                                            <nav aria-label="User pagination">
                                                {{ $users->links('vendor.pagination.bootstrap-4') }}
                                            </nav>
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
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            border: none;
            padding: 1.5rem;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .user-row:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.5em 0.8em;
            border-radius: 12px;
        }
        
        .btn {
            border-radius: 6px;
            font-weight: 500;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            border-bottom: 1px solid #e9ecef;
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }
        
        .form-control {
            border-radius: 6px;
            border: 1px solid #e1e5eb;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .alert-success {
            border-left-color: #28a745;
        }
        
        .alert-danger {
            border-left-color: #dc3545;
        }
        
        .pagination {
            margin-bottom: 0;
        }
        
        .page-item.active .page-link {
            background-color: #667eea;
            border-color: #667eea;
        }
        
        .page-link {
            border-radius: 6px;
            margin: 0 3px;
            border: 1px solid #e1e5eb;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: "Select roles",
                allowClear: true,
                width: '100%'
            });
            
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Smooth animations
            $('.user-row').hover(
                function() {
                    $(this).css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
        });
    </script>
@endsection