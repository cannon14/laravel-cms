@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
    <link href="/css/app/pages/pages.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/app/controllers/pages/ShowController.js" defer></script>
    <script src="/js/app/services/pages/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="ShowController">
    <div class="row">
        <div class="col-lg-12">
            @include('templates.page-templates.card-category-page')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        </div>
    </div>
</div>

@endsection