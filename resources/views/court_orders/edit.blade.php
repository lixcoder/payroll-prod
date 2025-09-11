@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-lg-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>Update Court Order</h3>
                        </div>
                        <div class="card-block">

                            <form method="POST" action="{{ url('court_orders/update/'.$court_order->id) }}" accept-charset="UTF-8">
                                @csrf

                                <fieldset>
                                    <div class="form-group">
                                        <label for="order_number">Order Number <span style="color:red">*</span></label>
                                        <input class="form-control" type="text" name="order_number" id="order_number"
                                               value="{{ $court_order->order_number }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description <span style="color:red">*</span></label>
                                        <textarea class="form-control" name="description" id="description" rows="3">{{ $court_order->description }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="effective_date">Effective Date <span style="color:red">*</span></label>
                                        <input class="form-control" type="date" name="effective_date" id="effective_date"
                                               value="{{ $court_order->effective_date }}">
                                    </div>

                                    <div class="form-actions form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Update Court Order</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
