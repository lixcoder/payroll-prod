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
                            <h3>Update Nssf Rate</h3>
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

                                    <form method="POST" action="{{{ URL::to('nssf') }}}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group">
                                                <label for="employee_contribution">employee contribution <span style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" name="employee_contribution"
                                                       id="employee_contribution"
                                                       value="{{ $nrate->employee_contribution}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="employer_contribution">employer contribution <span
                                                        style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" name="employer_contribution"
                                                       id="employer_contribution"
                                                       value="{{ $nrate->employer_contribution}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="total_contribution">Total contribution <span
                                                        style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" name="total_contribution"
                                                       id="total_contribution"
                                                       value="{{ $nrate->total_contribution}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="max_employee_nssf">maximum employee nssf <span style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" name="max_employee_nssf"
                                                       id="max_employee_nssf"
                                                       value="{{ $nrate->max_employee_nssf}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="max_employer_nssf">maximum employer nssf <span style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text" name="max_employer_nssf"
                                                       id="max_employer_nssf"
                                                       value="{{ $nrate->max_employer_nssf}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="nssf_lower_earning">Nssf lower earning<span
                                                        style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text"
                                                       name="nssf_lower_earning"
                                                       id="nssf_lower_earning" value="{{ $nrate->nssf_lower_earning}}">
                                            </div>

                                            <div class="form-group">
                                                <label for="nssf_upper_earning">Nssf upper earning <span
                                                        style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text"
                                                       name="nssf_upper_earning "
                                                       id="nssf_upper_earning " value="{{ $nrate->nssf_upper_earning }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="employer_nssf_upper_earning">employer nssf upper earning<span
                                                        style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text"
                                                       name="employer_nssf_upper_earning "
                                                       id="employer_nssf_upper_earning " value="{{ $nrate->employer_nssf_upper_earning }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="graduated_scale">graduated scale<span
                                                        style="color:red">*</span></label>
                                                <input class="form-control" placeholder="" type="text"
                                                       name="graduated_scale "
                                                       id="graduated_scale " value="{{ $nrate->graduated_scale }}">
                                            </div>

                                            <div class="form-actions form-group">

                                                <button type="submit" class="btn btn-primary btn-sm">Update Nssf Rate
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
    <div class="row">
    </div>
    <div class="row">
        <div class="col-lg-5">
        </div>

    </div>

@stop
