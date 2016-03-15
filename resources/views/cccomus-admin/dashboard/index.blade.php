@extends('cccomus-admin.layouts.master')

@section('title', 'Dashboard')

@section('styles')
    <link href="/css/app/dashboard/index.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/app/controllers/dashboard/IndexController.js"></script>
    <script src="/js/app/services/dashboard/service.js"></script>
    <script src="/js/app/services/feeds/service.js"></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController">
    <div class="row">
        <div class="col-lg-12">
            <h1>Dashboard</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Updates</h3>
                </div>
                <div class="panel-body">
                    <button type="button" class="btn btn-primary" ng-click="pullCardData()">Update Card Data</button>
                    <button type="button" class="btn btn-primary" ng-click="pullIssuerData()">Update Issuer Data</button>
                    <button type="button" class="btn btn-primary" ng-click="pullCategoryData()">Update Categories and Card Rankings </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Publishing</h3>
                </div>
                <div class="panel-body">
                    <button type="button" class="btn btn-primary" ng-click="publishToStaging()">Publish to Staging</button>
                    <button type="button" class="btn btn-primary" ng-click="publishToProduction()">Publish to Production</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row" ng-show="errors.length > 0">
        <div class="col-lg-12">
            <h2>Errors</h2>
            <ul>
                <li ng-repeat="error in errors"></li>
            </ul>
        </div>
    </div>
</div>

@endsection