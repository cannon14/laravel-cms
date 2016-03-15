@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12 text-center">

    <div class="panel panel-default">
    <div class="panel-heading text-center"><h1>Login</h1></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {!! Form::open(array('url' => 'login')) !!}
                    <p>
                        {!! Form::label('username', 'Username') !!}
                        {!! Form::text('username', Input::old('username')) !!}
                    </p>

                    <p>
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password') !!}
                    </p>

                    <p>{!! Form::submit('Submit!') !!}</p>

                {!! Form::close() !!}
                </div><!--col-lg-12-->
            </div><!--row-->
            <div class="row">
                <div class="col-lg-12 text-center">
                    {!! link_to('password/forgot', "Forgot Password?") !!}
                </div>
            </div>
        </div><!--panel-body-->
    </div><!--panel-->
 </div>
</div>

@stop