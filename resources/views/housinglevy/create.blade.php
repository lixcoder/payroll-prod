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
                            <h3>New Housing Levy</h3>
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
                                    <form action="{{ route('housinglevy.store') }}" method="POST">
                                        @csrf

                                        <div class="form-group">
                                            <label for="employee_rate">Employee Percentage (%)</label>
                                            <input type="number" step="0.01" name="employee_rate" id="employee_rate" 
                                                class="form-control" value="{{ old('employee_rate') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="employer_rate">Employer Percentage (%)</label>
                                            <input type="number" step="0.01" name="employer_rate" id="employer_rate" 
                                                class="form-control" value="{{ old('employer_rate') }}" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Save</button>
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
