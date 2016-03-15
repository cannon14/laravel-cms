@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-sm-12">

        <h3>Create User</h3>

        {!! Form::open(array("url"=>"users", "method"=>"POST")) !!}
        <div class="form-group">
            {!! Form::label('acl_id', 'Access Level', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::select('acl_id', $acl_list, '', array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('firstname', 'First Name', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::text('firstname', Input::old('firstname'), array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('lastname', 'Last Name', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::text('lastname', Input::old('lastname'), array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('username', 'Username', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::text('username', Input::old('username'), array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('password', 'Password', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::password('password', array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation', 'Confirm', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::password('password_confirmation', array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::text('email', Input::old('email'), array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                {!! Form::submit('Create', array('class'=>'btn btn-primary')) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts');
<script src="{!! url('assets/js/app/users.js') !!}"></script>
@endsection