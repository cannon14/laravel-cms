@extends('cccomus-admin.layouts.master')

@section('content')
    <div class="container">

<div class="row">
    <div class="col-lg-10">
        <h2>Card Issuers</h2>
    </div>
    <div class="col-lg-2 text-right">
        {{ link_to(url('issuers/create'), 'Add Issuer', array('class'=>'btn btn-primary btn-xs')) }}
    </div>
</div>
<!--row-->

<div class="row">
    <div class="col-lg-12">
        <table class="table table-hover datatable">
            <thead>
            <tr>
                <th>Issuer ID</th>
                <th>Name</th>
                <th>Total Products</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($issuers as $issuer)
                <tr>
                    <td>{{ $issuer->issuer_id }}</td>
                    <td>{{ $issuer->name }}</td>
                    <td>{{ count($issuer->products) }}</td>
                    <td>
                        <div class="action_items">{{ link_to(url('products/'.$issuer->issuer_id), 'Products', array('class'=>'btn btn-primary btn-xs')) }}</div>

                        <div class="action_items">
                            {{ Form::open(array('url'=>'issuers/'.$issuer->issuer_id.'/changeStatus', 'method'=>'GET')) }}
                            @if($issuer->disabled == 1)
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

                            {{ Form::submit($button_text, array('class'=>'btn btn-xs '.$button_class)) }}
                            {{ Form::close() }}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div><!--col-lg-12-->
</div><!--row-->
        </div><!--container-->

@endsection

@section('scripts');
<script src="{{ url('assets/js/app/issuers.js') }}"></script>
@endsection

