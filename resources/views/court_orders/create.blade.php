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

                            <form method="POST" action="{{ url('court_orders') }}" accept-charset="UTF-8">
                                @csrf

                                <fieldset>
                                    <div class="form-group">
                                        <label for="order_number">Court Order Number <span style="color:red">*</span></label>
                                        <input class="form-control" placeholder="Enter Court Order Number" 
                                               type="text" name="order_number" id="order_number" 
                                               value="{{ old('order_number') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" id="description" 
                                                  placeholder="Enter description">{{ old('description') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="effective_date">Effective Date <span style="color:red">*</span></label>
                                        <input class="form-control" type="date" name="effective_date" id="effective_date" 
                                               value="{{ old('effective_date') }}" required>
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
