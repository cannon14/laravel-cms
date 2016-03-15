@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12 text-center">

    <div class="panel panel-default">
    <div class="panel-heading text-center"><h1>Reset Password</h1></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                {!! Form::open(array('url' => 'reset', 'method'=>'get')) !!}

                    {!! Form::hidden('username', $username) !!}
                    <p>
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password') !!}
                    </p>

                    <p>
                        {!! Form::label('password_confirmation', 'Confirm') !!}
                        {!! Form::password('password_confirmation') !!}
                    </p>

                    <p>{!! Form::submit('Submit!') !!}</p>

                {!! Form::close() !!}
                </div><!--col-lg-12-->
            </div><!--row-->
        </div><!--panel-body-->
    </div><!--panel-->
 </div>
</div>

@stop