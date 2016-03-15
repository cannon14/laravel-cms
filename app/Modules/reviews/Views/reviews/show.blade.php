@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-8">
            <h2>{!!$product->product_name!!} Reviews</h2>
        </div><!--col-lg-6-->

        <div class="col-lg-4 text-right">
            {!! Form::open(array('url'=>'reviews/'.$product->alternate_product_id, 'method'=>'GET')) !!}
            {!! Form::text('search', $search_term) !!}
            {!! Form::submit('Search') !!}
            {!! Form::close() !!}
        </div><!--col-lg-6-->
    </div><!--row-->

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Review</th>
                    <th>Overall Rating</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td>{!! $review->review_id !!}</td>
                        <td>{!! $review->submission_date !!}</td>
                        <td>{!! $review->review_title !!}</td>
                        <td>{!! $review->review_text !!}</td>
                        <td>{!! $review->overall_rating !!}</td>
                        <td>
                            <div class="action_items">
                                {!! Form::open(array('url'=>'reviews/'.$review->review_id, 'method'=>'DELETE')) !!}
                                {!! Form::submit('Delete', array('class'=>'delete btn btn-primary btn-xs')) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!--col-lg-12-->
    </div><!--row-->

    <div class="row">
        <div class="col-lg-12 text-center">
            {!! $reviews->render() !!}
        </div><!--col-lg-12-->
    </div><!--row-->


@endsection

@section('scripts');
<script src="{!! url('assets/js/app/reviews.js') !!}"></script>
@endsection
