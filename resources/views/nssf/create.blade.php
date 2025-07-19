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
                            <h3>New Nssf Rate</h3>

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
                                    <form method="POST" action="{{{ URL::to('nssf') }}}" accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="lower_earnings_limit">Lower Earnings Limit <span style="color:red">*</span> </label>
                                                <input class="form-control" placeholder="" type="text" name="lower_earnings_limit"
                                                       id="lower_earnings_limit"
                                                       value="{{{ old('lower_earnings_limit') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="upper_earnings_limit">Upper Earnings Limit <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text" name="upper_earnings_limit"
                                                       id="upper_earnings_limit"
                                                       value="{{{ old('upper_earnings_limit') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="rate_tier1">Rate Tier 1 <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text" name="rate_tier1"
                                                       id="rate_tier1"
                                                       value="{{{ old('rate_tier1') }}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="rate_tier2">Rate Tier 2 <span style="color:red">*</span>
                                                </label>
                                                <input class="form-control" placeholder="" type="text" name="rate_tier2"
                                                       id="rate_tier2"
                                                       value="{{{ old('rate_tier2') }}}">
                                            </div>

                                            <div class="form-actions form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">Create Nssf Rate
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
@endsection