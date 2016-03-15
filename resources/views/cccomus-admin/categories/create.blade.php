@extends('cccomus-admin.layouts.master')

@section('title', 'Create User')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/categories/CreateController.js" defer></script>
    <script src="/js/app/services/categories/service.js" defer></script>
@endsection

@section('content')

    <div class="container" ng-controller="CreateController">

        <ol class="breadcrumb">
            <li><a href="{{ url('admin/categories') }}">Categories</a></li>
            <li class="active">Create</li>
        </ol>

        <div class="row">
            <div class="col-lg-12">
                <h1>Create Category</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form>

                    <div class="form-group">
                        <label class="control-label">State</label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="category.active" name="active" value="0"> Inactive
                        </label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="category.active" name="active" value="1"> Active
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="name" class="control-label">Name</label>
                        <input type="text" ng-model="category.name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="image" class="control-label">Image</label>
                        <input type="file" ng-model="category.image" id="image" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea class="form-control" id="description" ng-model="page.description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="slug" class="control-label">Name</label>
                        <input type="text" ng-model="category.slug" id="slug" class="form-control" required>
                    </div>

                    <button type="button" class="btn btn-primary" ng-click="create()">Create</button>
                </form>
            </div>
        </div>
    </div>

@endsection