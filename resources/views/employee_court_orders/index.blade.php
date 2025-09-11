@extends('layouts.main_hr')

@section('xara_cbs')
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="card">
                    <div class="card-header">
                        <h3>Employee Court Orders</h3>
                        <a href="{{ url('employee_court_orders/create') }}" class="btn btn-primary btn-sm float-right">New Court Order</a>
                    </div>
                    <div class="card-block">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Court Order</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeeCourtOrders as $eco)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $eco->employee->name }}</td>
                                        <td>{{ $eco->courtOrder->order_number }}</td>
                                        <td>{{ number_format($eco->amount, 2) }}</td>
                                        <td>
                                            <a href="{{ url('employee_court_orders/'.$eco->id.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ url('employee_court_orders/'.$eco->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this record?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
