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
                                <!-- Order Number -->
                                <div class="form-group">
                                    <label for="order_number">Order Number <span style="color:red">*</span></label>
                                    <input class="form-control" type="text" name="order_number" id="order_number"
                                           value="{{ $court_order->order_number }}" required>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description <span style="color:red">*</span></label>
                                    <textarea class="form-control" name="description" id="description">{{ $court_order->description }}</textarea>
                                </div>

                                <!-- Effective Date -->
                                <div class="form-group">
                                    <label for="effective_date">Effective Date <span style="color:red">*</span></label>
                                    <input class="form-control" type="date" name="effective_date" id="effective_date"
                                           value="{{ $court_order->effective_date }}" required>
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control" type="date" name="end_date" id="end_date"
                                           value="{{ $court_order->end_date }}">
                                </div>

                                <!-- Order Type -->
                                <div class="form-group">
                                    <label for="order_type">Order Type <span style="color:red">*</span></label>
                                    <select class="form-control" name="order_type" id="order_type" required>
                                        <option value="fixed" {{ $court_order->order_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ $court_order->order_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                </div>

                                <!-- Amount -->
                                <div class="form-group">
                                    <label for="amount">Amount (if Fixed)</label>
                                    <input class="form-control" type="number" step="0.01" name="amount" id="amount"
                                           value="{{ $court_order->amount }}">
                                </div>

                                <!-- Percentage -->
                                <div class="form-group">
                                    <label for="percentage">Percentage (if Percentage)</label>
                                    <input class="form-control" type="number" step="0.01" name="percentage" id="percentage"
                                           value="{{ $court_order->percentage }}">
                                </div>

                                <!-- Apply On -->
                                <div class="form-group">
                                    <label for="apply_on">Apply On <span style="color:red">*</span></label>
                                    <select class="form-control" name="apply_on" id="apply_on" required>
                                        <option value="gross" {{ $court_order->apply_on == 'gross' ? 'selected' : '' }}>Gross Salary</option>
                                        <option value="net" {{ $court_order->apply_on == 'net' ? 'selected' : '' }}>Net Salary</option>
                                    </select>
                                </div>

                                <!-- Submit -->
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
