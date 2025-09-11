@extends('layouts.main_hr')
@section('xara_cbs')

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <!-- [ page content ] start -->
                    <div class="card">
                        <div class="card-header">

                            @if (Session::has('flash_message'))
                                <div class="alert alert-success">
                                    {{ Session::get('flash_message') }}
                                </div>
                            @endif

                            @if (Session::has('delete_message'))
                                <div class="alert alert-danger">
                                    {{ Session::get('delete_message') }}
                                </div>
                            @endif

                            <h3>Court Orders</h3>

                            <div class="card-header-right">
                                <a class="dt-button btn-sm btn-primary" href="{{ url('court_orders/create') }}">New Court Order</a>
                            </div>
                        </div>

                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Number</th>
                                            <th>Order Type</th>
                                            <th>Amount</th>
                                            <th>Percentage</th>
                                            <th>Effective Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($court_orders as $order)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->order_type }}</td>
                                                <td>{{ $order->amount }}</td>
                                                <td>{{ $order->percentage }}</td>
                                                <td>{{ $order->effective_date }}</td>
                                                <td>{{ $order->end_date ?? 'Ongoing' }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            Action <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="{{ url('court_orders/edit/'.$order->id) }}">Update</a></li>
                                                            <li><a href="{{ url('court_orders/delete/'.$order->id) }}" onclick="return confirm('Are you sure you want to delete this court order?')">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- [ page content ] end -->
                </div>
            </div>
        </div>
    </div>

@stop
