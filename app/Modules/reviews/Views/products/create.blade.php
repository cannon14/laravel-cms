@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <h3>Create Product</h3>

            {!! Form::open(array("url"=>"products", "method"=>"POST", "class"=>"form-horizontal")) !!}
            <div class="form-group">
                {!! Form::label('issuer_id', 'Issuer', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-2">
                    {!! Form::select('issuer_id', $issuers, array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('product_name', 'Product Name', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-2">
                    {!! Form::text('product_name', Input::old('product_name'), array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('cccom_product_id', 'CCCOM Product ID', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-2">
                    {!! Form::text('cccom_product_id', Input::old('cccom_product_id'), array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('alternate_product_id', 'Alternate Product ID', array('class'=>'control-label col-sm-2')) !!}
                <div class="col-sm-2">
                    {!! Form::text('alternate_product_id', Input::old('alternate_product_id'), array('class'=>'form-control')) !!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    {!! Form::submit('Create', array('class'=>'btn btn-primary btn-xs')) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('scripts');
<script src="{!! url('assets/js/app/products.js') !!}"></script>
@endsection
