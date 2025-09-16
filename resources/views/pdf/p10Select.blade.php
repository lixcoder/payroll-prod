@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Select Year for P10 Form</h3>
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

                                    <form method="POST" action="{{ URL::to('payrollReports/p10form') }}"
                                          accept-charset="UTF-8">
                                        @csrf
                                        <fieldset>

                                            <div class="form-group">
                                                <label for="period">Period <span style="color:red">*</span></label>
                                                <div class="right-inner-addon ">
                                                    <i class="glyphicon glyphicon-calendar"></i>
                                                    <input required class="form-control year"
                                                           placeholder="Select Year"
                                                           type="text" name="period" id="period"
                                                           value="{{ old('period') }}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="type">Download as: <span style="color:red">*</span></label>
                                                <select id="type" name="type" class="form-control" required>
                                                    <option></option>
                                                    <option value="Excel">Excel</option>
                                                    <option value="Pdf">PDF</option>
                                                </select>
                                            </div>

                                            <div class="form-actions form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">Generate P10</button>
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

    <link href="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('media/jquery-1.8.0.min.js') }}"></script>
    <script src="{{ asset('jquery-ui-1.11.4.custom/jquery-ui.js') }}"></script>
    <script src="{{ asset('datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $('.year').datepicker({
                format: " yyyy", // Notice the space before yyyy (required by bootstrap-datepicker for year view)
                viewMode: "years",
                minViewMode: "years",
                endDate: '+0d',
                autoclose: true
            });
        });
    </script>
@stop
