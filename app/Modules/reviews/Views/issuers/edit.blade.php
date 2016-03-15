@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <h3>Edit Issuer</h3>

        {!! Form::open(array("url"=>"issuers/".$issuer->issuer_id, "method"=>"PUT")) !!}
        <div class="form-group">
            {!! Form::label('issuer_name', 'Issuer Name', array('class'=>'control-label col-sm-12')) !!}
            <div class="col-sm-12">
                {!! Form::text('issuer_name', $issuer->issuer_name, array('class'=>'form-control')) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                {!! Form::submit('Update', array('class'=>'btn btn-primary')) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts');
<script src="{!! url('assets/js/app/issuers.js') !!}"></script>
@endsection
