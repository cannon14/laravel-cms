@extends('cccomus-admin.layouts.master')

@section('title', 'Edit Static Page')

@section('styles')
    <!--Place specific style sheets here-->
@endsection

@section('scripts')
    <script src="/js/app/controllers/static-pages/EditController.js" defer></script>
    <script src="/js/app/services/static-pages/service.js" defer></script>
@endsection

@section('content')

    <div class="container" ng-controller="EditController">

        <ol class="breadcrumb">
            <li><a href="{{ url('admin/static/pages') }}">Pages</a></li>
            <li class="active">Edit Static Page</li>
        </ol>

        <div class="row">
            <div class="col-lg-12">
                <h1>Edit Static Page</h1>
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
                                <label for="description" class="control-label">Description</label>
                                <textarea ng-model="page.description" id="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="content" class="control-label">Content</label>
                                <textarea ng-model="page.content" id="content" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="slug" class="control-label">Slug</label>
                                <input type="text" ng-model="page.slug" id="slug" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Meta Data</h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="meta-tags" class="control-label">Keywords</label>
                                <input type="text" ng-model="page.meta_tags" id="meta_tags" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="meta-description" class="control-label">Description</label>
                                <textarea ng-model="page.meta_description" id="meta_description" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" ng-click="update()">Update</button>
                </form>
            </div>
        </div>
    </div>

@endsection