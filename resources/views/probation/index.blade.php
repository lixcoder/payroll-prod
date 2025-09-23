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
                                            <h5 class="mb-0"><i class="feather icon-user-check mr-2 text-primary"></i>Probation Settings</h5>
                                            <small class="text-muted">Manage employee probation periods</small>
                                        </div>
                                        <div class="card-header-right">
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProbation">
                                                <i class="feather icon-plus mr-1"></i> Add Setting
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="probationTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Period</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $count=1; ?>
                                                @forelse($probations as $probation)
                                                    <tr>
                                                        <td>{{$count++}}</td>
                                                        <td>
                                                            <span class="font-weight-bold text-primary">{{$probation->period}}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success">Active</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <button class="btn btn-outline-primary" data-toggle="modal" data-target="#editProbation{{$probation->id}}">
                                                                    <i class="feather icon-edit"></i>
                                                                </button>
                                                                <a href="{{url('probation/delete/'.$probation->id)}}" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this probation setting?')">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editProbation{{$probation->id}}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">
                                                                        <i class="feather icon-edit-2 mr-2 text-warning"></i>Edit Probation Setting
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{url('probation/update')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$probation->id}}">
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="period" class="font-weight-bold">Period <span class="text-danger">*</span></label>
                                                                            <select name="period" id="period" class="form-control" required>
                                                                                <option value="">Select Probation Period</option>
                                                                                <option value="3 Months" {{$probation->period == '3 Months' ? 'selected' : ''}}>3 Months</option>
                                                                                <option value="6 Months" {{$probation->period == '6 Months' ? 'selected' : ''}}>6 Months</option>
                                                                                <option value="9 Months" {{$probation->period == '9 Months' ? 'selected' : ''}}>9 Months</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">
                                                                            <i class="feather icon-x mr-1"></i> Cancel
                                                                        </button>
                                                                        <button class="btn btn-warning" type="submit">
                                                                            <i class="feather icon-save mr-1"></i> Update Setting
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i class="feather icon-user-check empty-state-icon" style="font-size: 48px; color: #dee2e6;"></i>
                                                                <h4 class="mt-3">No Probation Settings</h4>
                                                                <p class="text-muted">Get started by adding your first probation period setting.</p>
                                                                <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#addProbation">
                                                                    <i class="feather icon-plus mr-1"></i> Add Setting
                                                                </button>
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

    <!-- Add Probation Modal -->
    <div class="modal fade" id="addProbation">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="feather icon-plus-circle mr-2 text-success"></i>Add Probation Setting
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('probation/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="period" class="font-weight-bold">Period <span class="text-danger">*</span></label>
                            <select name="period" id="period" class="form-control" required>
                                <option value="">Select Probation Period</option>
                                <option value="3 Months">3 Months</option>
                                <option value="6 Months">6 Months</option>
                                <option value="9 Months">9 Months</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">
                            <i class="feather icon-x mr-1"></i> Cancel
                        </button>
                        <button class="btn btn-success" type="submit">
                            <i class="feather icon-save mr-1"></i> Add Setting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .empty-state {
            padding: 30px 0;
            text-align: center;
        }
        
        .empty-state-icon {
            font-size: 48px;
            color: #dee2e6;
            margin-bottom: 15px;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #2c3e50;
            background-color: #f8f9fa;
        }
        
        .badge {
            font-weight: 500;
            padding: 0.4em 0.6em;
        }
        
        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#probationTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search probation settings...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No probation settings available",
                    paginate: {
                        previous: "<i class='feather icon-chevron-left'></i>",
                        next: "<i class='feather icon-chevron-right'></i>"
                    }
                }
            });
        });
    </script>
@endsection