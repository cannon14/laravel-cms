@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-lg-10">
            <h2>{!! $issuer->issuer_name !!} Products</h2>
        </div><!--col-lg-12-->

        <div class="col-lg-2 text-right">
            {!! link_to(url('products/create'), 'Add Product', array('class'=>'btn btn-primary btn-xs')) !!}
        </div>
    </div><!--row-->

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover datatable">
                <thead>
                <tr>
                    <th>CCCOM ID</th>
                    <th>Issuer</th>
                    <th>Product Name</th>
                    <th>Alternate ID</th>
                    <th>Total Reviews</th>
                    <th>Staff Review</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{!! $product->cccom_product_id !!}</td>
                            <td>{!! $product->issuer->issuer_name !!}</td>
                            <td>{!! $product->product_name !!}</td>
                            <td>{!! $product->alternate_product_id !!}</td>
                            <td>{!! $review_count[$product->alternate_product_id] !!}</td>
                            <td>{!! $staff_review[$product->cccom_product_id] !!}</td>
                            <td>
                                <div class="action_items">
                                    {!! Form::open(array('url'=>'products/'.$product->cccom_product_id.'/edit', 'method'=>'GET')) !!}
                                    <button type="submit" class="btn btn-primary btn-xs" title="Edit"><span
                                                class="glyphicon glyphicon-pencil"></span></button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="action_items">
                                    {!! Form::open(array('url'=>'products/'.$product->cccom_product_id, 'method'=>'DELETE')) !!}
                                    <button type="submit" class="btn btn-primary btn-xs" title="Delete"><span
                                                class="glyphicon glyphicon-remove"></span></button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="action_items">
                                    {!! Form::open(array('url'=>'reviews/'.$product->alternate_product_id, 'method'=>'GET')) !!}
                                    <button type="submit" class="btn btn-primary btn-xs" title="User Reviews"><span
                                                class="glyphicon glyphicon-star"></span></button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="action_items">
                                    {!! Form::open(array('url'=>'staff_reviews/'.$product->cccom_product_id, 'method'=>'GET')) !!}
                                    <button type="submit" class="btn btn-primary btn-xs" title="Staff Review"><span
                                                class="glyphicon glyphicon-star-empty"></span>
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="action_items">
                                    {!! Form::open(array('url'=>'products/'.$product->cccom_product_id.'/changeStatus', 'method'=>'GET')) !!}
                                    @if($product->disabled == 1)
                                        <?php
                                        $button_text = 'Enable Reviews';
                                        $button_class = 'btn-danger';
                                        ?>
                                    @else
                                        <?php
                                        $button_text = 'Disable Reviews';
                                        $button_class = 'btn-success';
                                        ?>
                                    @endif
                                    <button type="submit" class="btn btn-primary btn-xs {!! $button_class !!}"
                                            title={!! $button_text !!}>
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!--col-lg-12-->
    </div><!--row-->

@endsection

@section('scripts');
<script src="{!! url('assets/js/app/products.js') !!}"></script>
@endsection

