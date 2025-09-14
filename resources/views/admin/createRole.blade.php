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

                                {{-- Validation errors --}}
                                @if(count($errors) > 0)
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <b>{{ $error }}</b>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="card-body">
                                    <form action="{{ route('roles.store') }}" method="post">
                                        @csrf
                                        @method('POST')

                                        {{-- Role Name --}}
                                        <div class="form-group col-sm-12">
                                            <label for="name" class="col-form-label">Role Name:</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Admin" required>
                                        </div>

                                        {{-- Permissions --}}
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label class="col-form-label font-weight-bold">Permissions:</label>

                                                {{-- Global Select All --}}
                                                <div class="mb-3">
                                                    <input type="checkbox" id="select-all">
                                                    <label for="select-all" class="ml-1">Select All</label>
                                                </div>

                                                @php
                                                    // Group permissions by 'group' field (or fallback)
                                                    $groupedPermissions = $permissions->groupBy('group');
                                                @endphp

                                                @foreach($groupedPermissions as $group => $perms)
                                                    <div class="border rounded p-3 mb-3">
                                                        {{-- Group header with group select --}}
                                                        <h6 class="mb-2">
                                                            <input type="checkbox" class="select-group"
                                                                   data-group="{{ Str::slug($group) }}">
                                                            <label class="ml-1"><strong>{{ $group }}</strong></label>
                                                        </h6>

                                                        {{-- Group permissions --}}
                                                        <div class="row">
                                                            @foreach($perms as $permission)
                                                                <div class="col-md-4 col-sm-6 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input permission-checkbox group-{{ Str::slug($group) }}"
                                                                               type="checkbox"
                                                                               name="permission[]"
                                                                               value="{{ $permission->id }}"
                                                                               id="perm_{{ $permission->id }}">
                                                                        <label class="form-check-label"
                                                                               for="perm_{{ $permission->id }}">
                                                                            {{ $permission->display_name ?? $permission->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Submit --}}
                                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script for checkbox behavior --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selectAll = document.getElementById('select-all');
            const groupCheckboxes = document.querySelectorAll('.select-group');
            const allPermissions = document.querySelectorAll('.permission-checkbox');

            // Global select all
            selectAll.addEventListener('change', function (event) {
                const checked = event.target.checked;
                allPermissions.forEach(cb => cb.checked = checked);
                groupCheckboxes.forEach(cb => cb.checked = checked);
            });

            // Per-group select
            groupCheckboxes.forEach(groupCheckbox => {
                groupCheckbox.addEventListener('change', function (event) {
                    const checked = event.target.checked;
                    const groupClass = '.group-' + groupCheckbox.dataset.group;
                    document.querySelectorAll(groupClass).forEach(cb => cb.checked = checked);
                    syncSelectAll();
                });
            });

            // Keep global select-all in sync
            allPermissions.forEach(cb => {
                cb.addEventListener('change', syncSelectAll);
            });

            function syncSelectAll() {
                const total = allPermissions.length;
                const checkedCount = document.querySelectorAll('.permission-checkbox:checked').length;
                selectAll.checked = total === checkedCount;
            }
        });
    </script>
@endsection
