@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <h3>Edit User</h3>

        {!! Form::open(array("url"=>"users/".$user->user_id, "method"=>"PUT")) !!}
        <div class="form-group">
            {!! Form::label('acl_id', 'Access Level', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::select('acl_id', $acl_list, $user->acl->acl_id, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('firstname', 'First Name', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::text('firstname', $user->first_name, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('lastname', 'Last Name', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::text('lastname', $user->last_name, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('username', 'Username', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::text('username', $user->username, array('class'=>'form-control')) !!}
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
                {!! Form::text('email', $user->email, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts');
<script src="{!! url('assets/js/app/users.js') !!}"></script>
@endsection