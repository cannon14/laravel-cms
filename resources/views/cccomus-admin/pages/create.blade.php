@extends('cccomus-admin.layouts.master')

@section('title', 'Create Page')

@section('styles')
    <!--Place specific style sheets here-->
@endsection

@section('scripts')
    <script src="/js/app/controllers/pages/CreateController.js" defer></script>
    <script src="/js/app/services/pages/service.js" defer></script>
@endsection

@section('content')

    <div class="container" ng-controller="CreateController as pages">

        <ol class="breadcrumb">
            <li><a href="{{ url('admin/pages') }}">Pages</a></li>
            <li class="active">Create Page</li>
        </ol>

        <div class="row">
            <div class="col-lg-12">
                <h1>Create Page</h1>
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
                                <select name="template_id" ng-model="page.template_id" class="form-control" required>
                                    <option value="" selected>--Select a Page Template--</option>
                                    @foreach($templates as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category_id" class="control-label">Category</label>
                                <select name="category_id" ng-model="page.category_id" class="form-control" required>
                                    <option value="" selected>--Select a Category--</option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category_id" class="control-label">Type</label>
                                <select name="page_type_id" ng-model="page.page_type_id" class="form-control" required>
                                    <option value="" selected>--Select a Page Type--</option>
                                    @foreach($pageTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description" class="control-label">Description</label>
                                <textarea ng-model="page.description" id="description" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="schumer_template_id" class="control-label">Schumer Type</label>
                                <select name="schumer_template_id" ng-model="page.schumer_template_id" class="form-control" required>
                                    <option value="" selected>--Select a Schumer Type--</option>
                                    @foreach($schumerTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
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

                    <button type="button" class="btn btn-primary" ng-click="create()">Create</button>
                </form>
            </div>
        </div>
    </div>

@endsection