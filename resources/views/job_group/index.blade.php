@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Job Groups</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a class="btn btn-info btn-sm" href="{{ URL::to('job_group/create')}}">new
                                            Job Group</a>
                                    </div>
                                    <table id="users" class="table table-condensed table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Job Group Name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($jgroups as $jgroup)
                                            <tr>
                                                <td> {{ $i }}</td>
                                                <td>{{ $jgroup->job_group_name }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <form action="{{ URL::to('job_group/' . $jgroup->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this job group?')">Delete</button>
                                                            </form>
                                                        </ul>
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
@endsection
