@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/services/file-service.js" defer></script>
    <script src="/js/app/controllers/issuers/CreateController.js" defer></script>
    <script src="/js/app/services/issuers/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="CreateController">

    <ol class="breadcrumb">
        <li><a href="{{ url('admin/issuers') }}">Issuers</a></li>
        <li class="active">Create Issuer</li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <h1>Create Issuer</h1>
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
                        <input type="file" ng-model="issuer.logo" name="logo" id="logo" class="form-control">
                </div>

                <button type="button" class="btn btn-primary" ng-click="create()">Create</button>
            </form>
        </div>
    </div>
</div>

@endsection