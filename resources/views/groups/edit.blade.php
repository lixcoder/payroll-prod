@extends('layouts.main_hr')
@section('xara_cbs')
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header">
                            <h3>Edit Group</h3>
                            <div class="card-header-right">
                                <a class="dt-button btn-sm" href="{{ route('groups.index') }}">Back to Groups</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('groups.update', $group->id) }}" accept-charset="UTF-8">
                                @csrf
                                @method('PUT')
                                <fieldset>
                                    <div class="form-group">
                                        <label for="name">Group Name <span style="color:red">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $group->name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description" id="description">{{ old('description', $group->description) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-sm">Update Group</button>
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