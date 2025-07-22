@extends('layouts.main_hr')
@section('xara_cbs')
    @include('partials.breadcrumbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Personal Relief Details</h3>
                            <hr>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>ID:</strong> {{ $reliefRate->id }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <strong>Amount:</strong> KES {{ number_format($reliefRate->amount, 2) }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <strong>Created:</strong> {{ $reliefRate->created_at }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <strong>Last Updated:</strong> {{ $reliefRate->updated_at }}
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <a href="{{ URL::to('personalrelief/edit/' . $reliefRate->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ URL::to('personalrelief') }}" class="btn btn-secondary btn-sm">Back
                                                to List</a>
                                            <a href="{{ URL::to('personalrelief/delete/' . $reliefRate->id) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this personal relief rate?')">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
