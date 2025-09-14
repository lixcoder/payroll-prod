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
                                <!-- Employee Dropdown -->
                                <div class="form-group">
                                    <label for="employee_id">Employee <span style="color:red">*</span></label>
                                    <select class="form-control" name="employee_id" id="employee_id" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">
                                                {{ $employee->personal_file_number }} - {{ $employee->first_name }} {{ $employee->middle_name }} {{ $employee->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Court Order Dropdown -->
                                <div class="form-group">
                                    <label for="court_order_id">Court Order <span style="color:red">*</span></label>
                                    <select class="form-control" name="court_order_id" id="court_order_id" required>
                                        <option value="">Select Court Order</option>
                                        @foreach($courtOrders as $co)
                                            <option value="{{ $co->id }}">{{ $co->order_number }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Start Date -->
                                <div class="form-group">
                                    <label for="start_date">Start Date <span style="color:red">*</span></label>
                                    <input class="form-control" type="date" name="start_date" id="start_date" required>
                                </div>

                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control" type="date" name="end_date" id="end_date">
                                </div>

                                <!-- Maximum Deduction -->
                                <div class="form-group">
                                    <label for="max_deduction">Maximum Deduction (Optional)</label>
                                    <input class="form-control" type="number" step="0.01" name="max_deduction" id="max_deduction">
                                </div>

                                <!-- Submit -->
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
