@extends('cccomus-admin.layouts.master')

@section('content')

<div class="row">
    <div class="col-lg-12">

    <div class="panel panel-default">
    <div class="panel-heading"><h2>Upload Reviews (CSV File)</h2></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {!! Form::open(array('url' => 'upload', 'role'=>'form', 'enctype'=>'multipart/form-data')) !!}

                    <div class="form-group">
                        {!! Form::label('issuer_id', 'Issuer') !!} <br>
                        {!! Form::select('issuer_id', $issuers) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('csv_file', 'CSV File') !!}
                        {!! Form::file('csv_file') !!}
                    </div>
                    <p>{!! Form::submit('Upload!', array('class'=>'btn btn-primary')) !!}</p>

                {!! Form::close() !!}
                </div><!--col-lg-12-->
            </div><!--row-->
    </div><!--panel-body-->
    </div><!--panel-->
    </div>
</div>

<div class="row">
    <div class="col-lg-12">

    <div class="panel panel-default">
    <div class="panel-heading"><h2>Upload Status</h2></div>
    <div class="panel-body" id="progress-bar-panel">
    </div><!--panel-body-->
    </div><!--panel-->
    </div>
</div>

@stop

@section('scripts')
    <script type="text/javascript" src="{{ url('/js/upload.js')}}"></script>
@stop