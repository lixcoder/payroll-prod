@extends('layouts.hr')
@section('content')

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-0"><i class="feather icon-edit-2 mr-2 text-primary"></i>Update Occurence Type</h5>
                                        <small class="text-muted">Modify occurence type details</small>
                                    </div>
                                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="feather icon-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-lg-8">
                                        @if ($errors->has())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}<br>        
                                                @endforeach
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        @if(Session::has('flash_message'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ Session::get('flash_message') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        <form method="POST" action="{{{ URL::to('occurencesettings/update/'.$occurence->id) }}}" accept-charset="UTF-8">
                                            @csrf
                                            <fieldset>
                                                <div class="form-group">
                                                    <label for="type">Occurence Type <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="feather icon-edit-1"></i></span>
                                                        </div>
                                                        <input class="form-control" placeholder="Enter occurence type" type="text" name="type" id="type" value="{{ $occurence->occurence_type }}" required>
                                                    </div>
                                                    <small class="form-text text-muted">Enter the name of the occurence type</small>
                                                </div>
                                                
                                                <div class="form-actions form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="feather icon-check-circle mr-1"></i> Update Occurence Type
                                                    </button>
                                                    <a href="{{ URL::to('occurencesettings') }}" class="btn btn-outline-secondary">
                                                        <i class="feather icon-x-circle mr-1"></i> Cancel
                                                    </a>
                                                </div>
                                            </fieldset>
                                        </form>
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

<style>
    .card-header {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-bottom: 1px solid #dee2e6;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    
    .input-group .form-control {
        border-left: none;
        padding-left: 0;
    }
    
    .input-group .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }
    
    .input-group .form-control:focus + .input-group-append .input-group-text {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .btn {
        border-radius: 4px;
        font-weight: 500;
        padding: 0.5rem 1rem;
    }
</style>

<script>
    $(document).ready(function() {
        // Add focus style to input group when focused
        $('.form-control').focus(function() {
            $(this).closest('.input-group').css('box-shadow', '0 0 0 0.2rem rgba(0, 123, 255, 0.25)');
            $(this).closest('.input-group').css('border-radius', '4px');
        }).blur(function() {
            $(this).closest('.input-group').css('box-shadow', 'none');
        });
    });
</script>

@stop