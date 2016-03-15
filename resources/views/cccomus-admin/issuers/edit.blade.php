@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/directives/file.js" defer></script>
    <script src="/js/app/controllers/issuers/EditController.js" defer></script>
    <script src="/js/app/services/issuers/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="EditController">

    <ol class="breadcrumb">
        <li><a href="{{ url('admin/issuers') }}">Issuers</a></li>
        <li class="active" ng-bind-html="issuer.name">Edit @{{ issuer.name }}</li>
    </ol>
    
    <div class="row">
        <div class="col-lg-12">
            <h1>Edit <span ng-bind-html="issuer.name"></span> <img src="/cccomus-assets/images/@{{ issuer.logo }}"></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="form-group">
                    <label class="control-label">State</label>
                    <label class="radio-inline">
                        <input type="radio" ng-model="issuer.active" name="active" value="0"> Inactive
                    </label>
                    <label class="radio-inline">
                        <input type="radio" ng-model="issuer.active" name="active" value="1"> Active
                    </label>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" ng-model="issuer.name" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="logo" class="control-label">Logo</label>
                    <select name="logo" ng-model="issuer.logo" class="form-control" required>
                        <option value="" selected>--Select Logo--</option>
                        <option ng-repeat="(key, value) in images" value="@{{ value }}">@{{ value }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="slug" class="control-label">Slug</label>
                    <input type="text" ng-model="issuer.slug" class="form-control" ng-value="issuer.name | slug">
                </div>

                <button type="button" class="btn btn-primary" ng-click="update()">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection