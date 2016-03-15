@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-12 text-center">

    <div class="panel panel-default">
    <div class="panel-heading text-center"><h1>Reset Password</h1></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <form action="{!! action('RemindersController@postReset') !!}" method="POST">
                    <input type="hidden" name="token" value="{!! $token !!}">
                    <input type="email" name="email">
                    <input type="password" name="password">
                    <input type="password" name="password_confirmation">
                    <input type="submit" value="Reset Password">
                </form>
                </div><!--col-lg-12-->
            </div><!--row-->
        </div><!--panel-body-->
    </div><!--panel-->
 </div>
</div>

@stop