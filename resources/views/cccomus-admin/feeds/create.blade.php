@extends('cccomus-admin.layouts.master')

@section('title', 'Create User')

@section('styles')
    <link href="/cccomus-admin/css/app/feeds/feeds.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/cccomus-admin/js/app/controllers/feeds/CreateController.js"></script>
    <script src="/cccomus-admin/js/app/services/feeds/service.js"></script>
@endsection

@section('content')

    <div class="container" ng-controller="CreateController as fds">
        <div class="row">
            <div class="col-lg-12">
                <h1>Create Feed</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form>
                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" ng-model="feed.name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="url" class="control-label">URL</label>
                        <input type="text" ng-model="feed.url" id="url" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="key" class="control-label">Key</label>
                        <input type="text" ng-model="feed.key" id="key" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary" ng-click="create()">Create</button>
                </form>
            </div>
        </div>
    </div>

@endsection