@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
    <link href="/css/app/pages/pages.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/app/controllers/pages/EditController.js" defer></script>
    <script src="/js/app/services/pages/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="EditController as pages">

    <ol class="breadcrumb">
        <li><a href="{{ url('admin/pages') }}">Pages</a></li>
        <li class="active" ng-bind-html="page.title">Edit @{{ page.title }}</li>
    </ol>

    <div class="row">
        <div class="col-lg-6">
            <h1>Edit @{{ page.title }}</h1>
        </div>
        <div class="col-lg-6 text-right">
            <button type="button" class="btn btn-primary" id="assign-cards-button">Assign/Edit Card List</button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Page Data</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">State</label>
                            <label class="radio-inline">
                                <input type="radio" ng-model="page.active" name="active" value="0"> Inactive
                            </label>
                            <label class="radio-inline">
                                <input type="radio" ng-model="page.active" name="active" value="1"> Active
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" ng-model="page.title" id="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="template_id" class="control-label">Template</label>
                            <select ng-model="page.template_id" ng-options="key as value for (key , value) in templates" class="form-control"></select>
                        </div>

                        <div class="form-group">
                            <label for="categories" class="control-label">Category</label>
                            <select ng-model="page.category_id" ng-options="key as value for (key , value) in categories" class="form-control"></select>
                        </div>

                        <div class="form-group">
                            <label for="page_type_id" class="control-label">Page Type</label>
                            <select ng-model="page.page_type_id" ng-options="key as value for (key , value) in pageTypes" class="form-control"></select>
                        </div>

                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>
                            <textarea ng-model="page.description" id="description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="schumer_template_id" class="control-label">Schumer Type</label>
                            <select ng-model="page.schumer_template_id" ng-options="key as value for (key , value) in schumerTypes" class="form-control">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="slug" class="control-label">Slug</label>
                            <input type="text" ng-model="page.slug" id="slug" class="form-control" value="">
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Meta Description</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="meta-tags" class="control-label">Meta Tags</label>
                            <input type="text" ng-model="page.meta_tags" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="meta-description" class="control-label">Meta Description</label>
                            <textarea ng-model="page.meta_description" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" ng-click="update()">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection