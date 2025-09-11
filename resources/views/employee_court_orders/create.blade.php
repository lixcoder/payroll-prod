@extends('layouts.main_hr')

@section('xara_cbs')
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="card">
                    <div class="card-header">
                        <h3>Assign Court Order to Employee</h3>
                    </div>
                    <div class="card-block">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ url('employee_court_orders') }}">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <label for="employee_id">Employee <span style="color:red">*</span></label>
                                    <select class="form-control" name="employee_id" id="employee_id" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="court_order_id">Court Order <span style="color:red">*</span></label>
                                    <select class="form-control" name="court_order_id" id="court_order_id" required>
                                        <option value="">Select Court Order</option>
                                        @foreach($courtOrders as $co)
                                            <option value="{{ $co->id }}">{{ $co->order_number }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="amount">Amount <span style="color:red">*</span></label>
                                    <input class="form-control" type="number" name="amount" id="amount" step="0.01" required>
                                </div>

                                <div class="form-actions form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
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
