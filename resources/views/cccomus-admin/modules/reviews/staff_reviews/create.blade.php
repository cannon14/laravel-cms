@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2>Create Staff Review</h2>
        </div><!--col-lg-12-->
    </div><!--row-->

    <br>

    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(array("url"=>"staff_reviews", "method"=>"POST", "files"=>true, "class"=>"form-horizontal")) !!}
            {!! Form::hidden('cccom_product_id', $cccom_product_id) !!}
            <div class="form-group">
                {!! Form::label('member_name', 'Member Name', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('member_name', Input::old('member_name'), array('class'=>'form-control', 'placeholder'=>'Member Name')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('member_title', 'Member Title', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('member_title', Input::old('member_title'), array('class'=>'form-control', 'placeholder'=>'Member Title')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('member_image_path', 'Path to Member Image', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('member_image_path', Input::old('member_image_path'), array('class'=>'form-control', 'placeholder'=>'http://www.path.to.member.image.com/image.png')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('member_url', 'Member Site', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('member_url', Input::old('member_url'), array('class'=>'form-control', 'placeholder'=>'http://www.member_site_url.com')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('review_title', 'Review Title', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('review_title', Input::old('review_title'), array('class'=>'form-control', 'placeholder'=>'Review Title')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('review', 'Review', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::textarea('review', Input::old('review'), array('class'=>'form-control', 'id'=>'review')) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-9">
                    {!! Form::submit('Create', array('class'=>'btn btn-primary')) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @endsection

@section('scripts');
<script src="{!! url('assets/js/app/staff_reviews.js') !!}"></script>
@endsection