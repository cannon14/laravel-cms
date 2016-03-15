@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <h3>Edit Product</h3>

        <br>

        {!! Form::open(array("url"=>"products/".$product->cccom_product_id, "method"=>"PUT", "class"=>"form-horizontal")) !!}
        <div class="form-group">
            {!! Form::hidden('issuer_id', $product->issuer_id) !!}
            {!! Form::label('product_name', 'Product Name', array('class'=>'control-label col-sm-2')) !!}
            <div class="col-sm-2">
                {!! Form::text('product_name', $product->product_name, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('cccom_product_id', 'CCCOM Product ID', array('class'=>'control-label col-sm-2')) !!}
            <div class="col-sm-2">
                {!! Form::text('cccom_product_id', $product->cccom_product_id, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('alternate_product_id', 'Alternate Product ID', array('class'=>'control-label col-sm-2')) !!}
            <div class="col-sm-2">
                {!! Form::text('alternate_product_id', $product->alternate_product_id, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts');
<script src="{!! url('assets/js/app/products.js') !!}"></script>
@endsection
