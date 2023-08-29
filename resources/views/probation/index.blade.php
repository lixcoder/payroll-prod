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
                                <div class="card-body">
                                    <button class="btn btn-sm btn-primary btn-round" data-toggle="modal"
                                            data-target="#addProbation">
                                        Add Probation Setting
                                    </button>
                                    <table class="table table-bordered table-stripped mt-2">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Period</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count=1?>
                                        @forelse($probations as $probation)
                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{$probation->period}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#editProbation{{$probation->id}}">Edit</a>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="editProbation{{$probation->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{url('probation/update')}}" method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="{{$probation->id}}">
                                                                <div class="form-group">
                                                                    <label for="period">Period</label>
                                                                    <select name="period" id="period" class="form-control">
                                                                        <option disabled>Select Probation Period</option>
                                                                        <option>3 Months</option>
                                                                        <option>6 Months</option>
                                                                        <option>9 Months</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-center">
                                                                <button class="btn btn-sm btn-warning btn-round" type="button" data-dismiss="modal">
                                                                    Not Now
                                                                </button>
                                                                <button class="btn btn-sm btn-success btn-round" type="submit">
                                                                    Add Setting
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">
                                                        <i class="fa fa-file-alt fa-5x text-info"></i>
                                                        <p class="text-bold">Add Probation Settings</p>
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
    <div class="modal fade" id="addProbation">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('probation/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="period">Period</label>
                            <select name="period" id="period" class="form-control">
                                <option disabled>Select Probation Period</option>
                                <option>3 Months</option>
                                <option>6 Months</option>
                                <option>9 Months</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-warning btn-round" type="button" data-dismiss="modal">
                            Not Now
                        </button>
                        <button class="btn btn-sm btn-success btn-round" type="submit">
                            Add Setting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
