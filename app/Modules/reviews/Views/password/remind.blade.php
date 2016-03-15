@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12 text-center">

    <div class="panel panel-default">
    <div class="panel-heading text-center"><h2>Send Password Reminder</h2></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {!! Form::open(array('url' => 'password/remind')) !!}
                    <label for="email">Email:</label>
                    <input type="email" name="email">
                    <input type="submit" value="Send">
                {!! Form::close() !!}
            </div><!--col-lg-12-->
         </div><!--row-->
    </div><!--panel-body-->
    </div><!--panel-->
    </div>
</div>

@stop