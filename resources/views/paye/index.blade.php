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
                            <h3>Paye Rates</h3>
                            <hr>
                        </div>
                        

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <a class="btn btn-info btn-sm-2" href="{{ URL::to('paye/create')}}">add new paye
                                            rates slab</a>
                                    </div>
                                    <div class="mb-2">
                                        <a class="btn btn-info btn-sm-2" href="{{ URL::to('housinlevy/create')}}">add housing levy</a>
                                    </div>
                                    
                                    <table id="users" class="table table-condensed table-bordered table-hover">


                                        <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Income From</th>
                                            <th>Income To</th>
                                            <th>percentage</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

    
                                        @foreach($prates as $prate)
                                            <tr>

                                                <td>{{ $prate->id }}</td>
                                                <td>{{ $prate->income_from }}</td>
                                                <td>{{ $prate->income_to }}</td>
                                                <td>{{ $prate->percentage }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                class="btn btn-info btn-sm dropdown-toggle"
                                                                data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>

                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a href="{{URL::to('paye/edit/'.$prate->id)}}">Update</a>
                                                            </li>

                                                            <li>
                                                                <a href="{{URL::to('paye/delete/'.$prate->id)}}">Delete</a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </td>
                                
                                            </tr>

                                            
                                       


                                        </tbody>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    </div>


    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-body">


                </div>


            </div>

        </div>

@stop
