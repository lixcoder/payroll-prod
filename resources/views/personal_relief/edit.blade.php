@extends('layouts.main_hr')
@section('xara_cbs')
@include('partials.breadcrumbs')
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Update Personal Relief</h3>
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
                                <form method="POST" action="{{{ URL::to('personalrelief/update/'.$reliefRate->id) }}}"
                                      accept-charset="UTF-8">
                                    @csrf
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="amount">Amount (KES) <span style="color:red">*</span></label>
                                            <input class="form-control" placeholder="Enter relief amount" type="number" 
                                                   name="amount" id="amount" step="0.01" min="0"
                                                   value="{{ $reliefRate->amount}}">
                                        </div>
                                        <div class="form-actions form-group">
                                            <button type="submit" class="btn btn-primary btn-sm">Update Personal Relief</button>
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