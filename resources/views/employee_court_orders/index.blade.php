@extends('layouts.main_hr')

@section('xara_cbs')
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="card">
                    <div class="card-header">
                        <h3>Employee Court Orders</h3>
                        <a href="{{ url('employee_court_orders/create') }}" class="btn btn-primary btn-sm float-right">
                            New Court Order
                        </a>
                    </div>
                    <div class="card-block">
                        @if(Session::has('flash_message'))
                            <div class="alert alert-success">
                                {{ Session::get('flash_message') }}
                            </div>
                        @endif

                        @if(Session::has('delete_message'))
                            <div class="alert alert-danger">
                                {{ Session::get('delete_message') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Court Order</th>
                                    <th>Deduction</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeeCourtOrders as $eco)
                                    <tr>
                                        <!-- Row number -->
                                        <td>{{ $loop->iteration }}</td>
                                        
                                        <!-- Employee info -->
                                        <td>
                                            {{ $eco->employee->personal_file_number }} - 
                                            {{ $eco->employee->first_name }} 
                                            {{ $eco->employee->middle_name }} 
                                            {{ $eco->employee->last_name }}
                                        </td>

                                        <!-- Court order reference -->
                                        <td>{{ $eco->courtOrder->order_number }}</td>

                                        <!-- Deduction Details -->
                                        <td>
                                            @if($eco->courtOrder->order_type === 'fixed')
                                                {{ number_format($eco->courtOrder->amount, 2) }} 
                                                <small>({{ $eco->courtOrder->currency ?? 'KES' }})</small>
                                            @elseif($eco->courtOrder->order_type === 'percentage')
                                                {{ $eco->courtOrder->percentage }}% 
                                                of {{ ucfirst($eco->courtOrder->apply_on ?? 'gross') }}
                                            @endif

                                            @if($eco->max_deduction)
                                                <br><small class="text-muted">Capped at {{ number_format($eco->max_deduction, 2) }}</small>
                                            @endif
                                        </td>
                                        <!-- Dates -->
                                        <td>{{ $eco->start_date }}</td>
                                        <td>{{ $eco->end_date ?? 'Ongoing' }}</td>

                                        <!-- Status -->
                                        <td>{{ ucfirst($eco->status) }}</td>

                                        <!-- Actions -->
                                        <td>
                                            <a href="{{ url('employee_court_orders/'.$eco->id.'/edit') }}" 
                                               class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ url('employee_court_orders/'.$eco->id) }}" 
                                                  method="POST" style="display:inline;">
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
