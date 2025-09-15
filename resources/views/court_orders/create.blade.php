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
                        <h3>New Court Order</h3>
                    </div>
                    <div class="card-block">
                        <form method="POST" action="{{ url('court_orders') }}">
                            @csrf
                            <fieldset>
                                <!-- Order Number -->
                                <div class="form-group">
                                    <label for="order_number">Court Order Number <span style="color:red">*</span></label>
                                    <input class="form-control" type="text" name="order_number" id="order_number"
                                           value="{{ old('order_number') }}" required>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description">{{ old('description') }}</textarea>
                                </div>

                                <!-- Effective Date -->
                                <div class="form-group">
                                    <label for="effective_date">Effective Date <span style="color:red">*</span></label>
                                    <input class="form-control" type="date" name="effective_date" id="effective_date"
                                           value="{{ old('effective_date') }}" required>
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control" type="date" name="end_date" id="end_date"
                                           value="{{ old('end_date') }}">
                                </div>

                                <!-- Order Type -->
                                <div class="form-group">
                                    <label for="order_type">Order Type <span style="color:red">*</span></label>
                                    <select class="form-control" name="order_type" id="order_type" required>
                                        <option value="garnishment" {{ old('order_type') == 'garnishment' ? 'selected' : '' }}>Garnishment</option>
                                        <option value="attachment" {{ old('order_type') == 'attachment' ? 'selected' : '' }}>Attachment</option>
                                        <option value="deduction" {{ old('order_type') == 'deduction' ? 'selected' : '' }}>Deduction</option>
                                    </select>
                                </div>

                                <!-- Rate Type -->
                                <div class="form-group">
                                    <label for="rate_type">Rate Type <span style="color:red">*</span></label>
                                    <select class="form-control" name="rate_type" id="rate_type" required>
                                        <option value="fixed" {{ old('rate_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="percentage" {{ old('rate_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                </div>

                                <!-- Amount -->
                                <div class="form-group">
                                    <label for="amount">Amount (if Fixed)</label>
                                    <input class="form-control" type="number" step="0.01" name="amount" id="amount"
                                           value="{{ old('amount') }}">
                                </div>

                                <!-- Percentage -->
                                <div class="form-group">
                                    <label for="percentage">Percentage (if Percentage)</label>
                                    <input class="form-control" type="number" step="0.01" name="percentage" id="percentage"
                                           value="{{ old('percentage') }}">
                                </div>

                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Create Court Order</button>
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
