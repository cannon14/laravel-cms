@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2>Edit Staff Review</h2>
        </div><!--col-lg-12-->
    </div><!--row-->

    <br>

    <div class="row">
        <div class="col-lg-12">
            {!! Form::open(array("url"=>"staff_reviews/".$review->cccom_product_id, "method"=>"PUT", "files"=>true, "class"=>"form-horizontal")) !!}
            <div class="form-group">
                {!! Form::label('product_name', 'Product Name', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('product_name', $review->product->product_name, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('member_name', 'Staff Member Name', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('member_name', $review->member_name, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('member_title', 'Staff Member Title', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('member_title', $review->member_title, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('member_image_path', 'Path to Member Image', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('member_image_path', $review->member_image_path, array('class'=>'form-control', 'placeholder'=>'http://www.path.to.member.image.com/image.png')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('member_url', 'Staff Member Site', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('member_url', $review->member_url, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('review_title', 'Review Title', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::text('review_title', $review->review_title, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('review', 'Review', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-9">
                    {!! Form::textarea('review', $review->review, array('class'=>'form-control', 'id'=>'review')) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-9">
                    {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts');
<script src="{!! url('assets/js/app/staff_reviews.js') !!}"></script>
@endsection