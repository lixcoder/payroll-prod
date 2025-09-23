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
                                    <h5 class="mb-0">
                                        <i class="fas fa-history mr-2 text-primary"></i>
                                        Audit Trail
                                    </h5>
                                    <small class="text-muted">Track system activities and changes</small>
                                </div>
                                @can('manage_audits')
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-secondary" id="refreshBtn">
                                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                                        </button>
                                    </div>
                                @endcan
                            </div>
                        </div>

                        @if (Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <div>{{ Session::get('error') }}</div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="card-block">
                            <div class="table-responsive">
                                <table id="auditTable" class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>User</th>
                                            <th>Entity</th>
                                            <th>Action</th>
                                            <th class="text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($audits as $audit)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="font-weight-bold text-dark">
                                                            {{ \Carbon\Carbon::parse($audit->created_at)->format('M j, Y') }}
                                                        </span>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($audit->created_at)->format('g:i A') }}
                                                        </small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                        <span class="font-weight-semibold">{{ $audit->user }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $audit->entity }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $actionClass = [
                                                            'created' => 'success',
                                                            'updated' => 'warning',
                                                            'deleted' => 'danger',
                                                            'viewed' => 'info'
                                                        ][strtolower($audit->action)] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge badge-{{ $actionClass }}">
                                                        {{ ucfirst($audit->action) }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    @if($audit->amount)
                                                        <span class="font-weight-bold text-success">
                                                            {{ number_format($audit->amount, 2) }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <div class="empty-state">
                                                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">No Audit Records Found</h5>
                                                        <p class="text-muted">System activities will appear here once they occur</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($audits instanceof \Illuminate\Pagination\LengthAwarePaginator && $audits->hasPages())
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div class="text-muted">
                                        Showing {{ $audits->firstItem() }} to {{ $audits->lastItem() }} of {{ $audits->total() }} entries
                                    </div>
                                    <nav aria-label="Audit pagination">
                                        {{ $audits->links('vendor.pagination.bootstrap-4') }}
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px 10px 0 0;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tr:hover {
            background-color: #f8f9fa;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.5em 0.8em;
            border-radius: 12px;
            font-size: 0.85rem;
        }
        
        .avatar {
            font-size: 14px;
        }
        
        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-1px);
        }
        
        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .alert-danger {
            border-left-color: #dc3545;
        }
        
        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
        }
        
        .pagination {
            margin-bottom: 0;
        }
        
        .page-item.active .page-link {
            background-color: #667eea;
            border-color: #667eea;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Refresh button
            $('#refreshBtn').on('click', function () {
                $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Refreshing...');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
@stop