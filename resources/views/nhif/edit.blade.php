@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Update Shif Rate</h3>

                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger">
                                                {{ $error }}<br>
                                            </div>
                                        @endforeach
                                    @endif
                                    <form method="POST" action="{{{ URL::to('nhif/update/'.$nrate->id) }}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">Rate <span style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" name="rate"
                                                       id="rate"
                                                       value="{{ $nrate->rate }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">Minimum Amount <span style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" name="minimum_amount"
                                                       id="minimum_amount"
                                                       value="{{ $nrate->minimum_amount }}">
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Update Shif Rate
                                                </button>
                                            </div>

                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop