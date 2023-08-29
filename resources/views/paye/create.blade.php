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
                            <h3>New Paye Rate</h3>
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
                                    <form method="POST" action="{{{ url('paye') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">income from <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="income_from" id="income_from"
                                                       value="{{{ old('income_from') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">income to <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="income_to" id="income_to"
                                                       value="{{{ old('income_to') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="percentage">percentage<span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="percentage" id="percentage"
                                                       value="{{{ old('percentage') }}}">
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Paye Rate</button>
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
    <div class="row">
    </div>
    <div class="row">
        <div class="col-lg-5">

        </div>

    </div>

@stop
