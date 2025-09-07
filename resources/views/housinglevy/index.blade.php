@extends('layouts.main_hr')

@section('xara_cbs')
    @include('partials.breadcrumbs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Housing Levy Rates</h3>
                            <hr>
                        </div>
                        
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a class="btn btn-info btn-sm-2" href="{{ URL::to('housinglevy/create') }}">
                                            Add Housing Levy
                                        </a>
                                    </div>
                                    
                                    <table id="users" class="table table-condensed table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee Percentage</th>
                                                <th>Employer Percentage</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hrates as $hrate)
                                                <tr>
                                                    <td>{{ $hrate->id }}</td>
                                                    <td>{{ $hrate->employee_rate }}%</td>
                                                    <td>{{ $hrate->employer_rate }}%</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                    class="btn btn-info btn-sm dropdown-toggle"
                                                                    data-toggle="dropdown" aria-expanded="false">
                                                                Action <span class="caret"></span>
                                                            </button>

                                                            <ul class="dropdown-menu" role="menu">
                                                                <li>
                                                                    <a href="{{ URL::to('housinglevy/edit/'.$hrate->id) }}">
                                                                        Update
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ URL::to('housinglevy/delete/'.$hrate->id) }}"
                                                                       onclick="return confirm('Are you sure you want to delete this record?')">
                                                                        Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    @if($hrates->isEmpty())
                                        <div class="alert alert-info mt-3">
                                            No housing levy rates found.
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
@stop
