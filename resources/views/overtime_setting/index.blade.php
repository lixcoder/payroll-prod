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
                                            <h5 class="mb-0"><i class="feather icon-clock mr-2 text-primary"></i>Overtime Settings</h5>
                                            <small class="text-muted">Manage overtime calculation rules and rates</small>
                                        </div>
                                        <div class="card-header-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSettings">
                                                <i class="feather icon-plus mr-1"></i> Add Settings
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="overtimeSettingsTable" class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Type</th>
                                                    <th>Rate</th>
                                                    <th>Salary Range</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $count = 1; ?>
                                                @forelse($settings as $setting)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>
                                                            <span class="badge badge-{{ $setting->type == 'Daily' ? 'info' : 'warning' }}">
                                                                {{ $setting->type }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="font-weight-bold text-primary">{{ $setting->rate }}x</span>
                                                        </td>
                                                        <td>
                                                            {{ $setting->min }} - {{ $setting->max }}
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-success">Active</span>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#updateSettings{{$setting->id}}">
                                                                    <i class="feather icon-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteSettings{{$setting->id}}">
                                                                    <i class="feather icon-trash-2"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Update Modal -->
                                                    <div class="modal fade" id="updateSettings{{$setting->id}}">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">
                                                                        <i class="feather icon-edit-2 mr-2 text-primary"></i>Update Overtime Settings
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{url('overtime_setting/update')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$setting->id}}">
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="type" class="font-weight-bold">Type <span class="text-danger">*</span></label>
                                                                            <select id="type" name="type" class="form-control" required>
                                                                                <option value="Daily" {{ $setting->type == 'Daily' ? 'selected' : '' }}>Daily</option>
                                                                                <option value="Hourly" {{ $setting->type == 'Hourly' ? 'selected' : '' }}>Hourly</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="min" class="font-weight-bold">Salary Range <span class="text-danger">*</span></label>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <input id="min" type="number" name="min" class="form-control" placeholder="Minimum" value="{{$setting->min}}" required>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <input id="max" type="number" name="max" class="form-control" placeholder="Maximum" value="{{$setting->max}}" required>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="rate" class="font-weight-bold">Rate <span class="text-danger">*</span></label>
                                                                            <input id="rate" type="number" step="0.01" name="rate" class="form-control" value="{{$setting->rate}}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                                                            <i class="feather icon-x mr-1"></i> Cancel
                                                                        </button>
                                                                        <button type="submit" class="btn btn-primary">
                                                                            <i class="feather icon-save mr-1"></i> Update Settings
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteSettings{{$setting->id}}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-danger">
                                                                        <i class="feather icon-alert-triangle mr-2"></i>Confirm Deletion
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to delete this overtime setting?</p>
                                                                    <p class="font-weight-bold">Type: {{ $setting->type }}, Rate: {{ $setting->rate }}x</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                                                        <i class="feather icon-x mr-1"></i> Cancel
                                                                    </button>
                                                                    <a href="{{url('overtime_setting/delete/'.$setting->id)}}" class="btn btn-danger">
                                                                        <i class="feather icon-trash-2 mr-1"></i> Delete
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center py-5">
                                                            <div class="empty-state">
                                                                <i class="feather icon-clock empty-state-icon" style="font-size: 48px; color: #dee2e6;"></i>
                                                                <h4 class="mt-3">No Overtime Settings</h4>
                                                                <p class="text-muted">Get started by adding your first overtime calculation rule.</p>
                                                                <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addSettings">
                                                                    <i class="feather icon-plus mr-1"></i> Add Settings
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

        <!-- Add Settings Modal -->
        <div class="modal fade" id="addSettings">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="feather icon-plus-circle mr-2 text-success"></i>Add Overtime Settings
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{url('overtime_setting/store')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="type" class="font-weight-bold">Type <span class="text-danger">*</span></label>
                                <select id="type" name="type" class="form-control" required>
                                    <option value="">Select Type</option>
                                    <option value="Daily">Daily</option>
                                    <option value="Hourly">Hourly</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="min" class="font-weight-bold">Salary Range <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input id="min" type="number" name="min" class="form-control" placeholder="Minimum" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="max" type="number" name="max" class="form-control" placeholder="Maximum" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rate" class="font-weight-bold">Rate <span class="text-danger">*</span></label>
                                <input id="rate" type="number" step="0.01" name="rate" class="form-control" placeholder="Enter rate multiplier" required>
                                <small class="form-text text-muted">e.g., 1.5 for time and a half</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                                <i class="feather icon-x mr-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="feather icon-save mr-1"></i> Add Settings
                            </button>
                        </div>
                    </form>
                </div>
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
        
        .modal-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#overtimeSettingsTable').DataTable({
                responsive: true,
                pageLength: 10,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search settings...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    emptyTable: "No settings available",
                    paginate: {
                        previous: "<i class='feather icon-chevron-left'></i>",
                        next: "<i class='feather icon-chevron-right'></i>"
                    }
                }
            });
        });
    </script>
@endsection