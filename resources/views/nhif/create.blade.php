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
                            <h3>New Nhif Rate</h3>
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
                                    <form method="POST" action="{{{ url('nhif') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="username">minimum <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="minimum" id="minimum"
                                                       value="{{{ old('minimum') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">maximum <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="maximum" id="maximum"
                                                       value="{{{ old('maximum') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="username">contribution<span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="contribution" id="contribution"
                                                       value="{{{ old('contribution') }}}">
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Create Nhif Rate</button>
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
