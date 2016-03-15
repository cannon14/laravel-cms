@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-10">
            @if(isset($review))
                <h2>{!!$review->product->product_name!!} - Staff Review</h2>
            @else
                <h2>Staff Review</h2>
            @endif
        </div><!--col-lg-10-->
        <div class="col-lg-2 text-right">
            @if($review == null)
                {!! Form::open(array('url'=>'staff_reviews/create', 'method'=>'GET')) !!}
                {!! Form::hidden('cccom_product_id', $product_id) !!}
                {!! Form::submit('Add Review', array('class'=>'btn btn-primary btn-xs')) !!}
                {!! Form::close() !!}
            @else
                {!! Form::open(array('url'=>'staff_reviews/'.$review->cccom_product_id.'/edit', 'method'=>'GET', 'class'=>'action_items')) !!}
                {!! Form::submit('Edit', array('class'=>'btn btn-primary btn-xs')) !!}
                {!! Form::close() !!}

                {!! Form::open(array('url'=>'staff_reviews/'.$review->cccom_product_id, 'method'=>'DELETE', 'class'=>'action_items')) !!}
                {!! Form::submit('Delete', array('class'=>'btn btn-primary btn-xs')) !!}
                {!! Form::close() !!}
            @endif
        </div>
    </div><!--row-->

    @if(isset($review))
        <div class="row">
            <div class="col-lg-2 staff_image">
                {!! HTML::image($review->member_image_path, $review->member_name.' Image', array('style'=>'width:100px')) !!}
            </div>
            <div class="col-lg-10">
                <p><strong>By:</strong> {!! $review->member_name !!}</p>
                @if(isset($review->member_title))
                    <p><strong>Title:</strong> {!! $review->member_title !!}</p>
                @endif
                <p><strong>Updated:</strong> {!! $review->updated_at !!}</p>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-lg-12">
                @if(isset($review->review_title))
                    <p>{!! $review->review_title !!}</p>
                @else
                    <p>Apply for the {!! $review->product->product_name !!} by filling out the secure online credit application.</p>
                @endif
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-lg-12">
                {!! $review->review !!}
            </div>
        </div>
    @else
        <p>No Review Available For This Product!</p>
    @endif

    @endsection

@section('scripts');
<script src="{!! url('assets/js/app/staff_reviews.js') !!}"></script>
@endsection