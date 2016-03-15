@extends('cccomus-admin.layouts.master')

@section('title', 'Create COntent Block')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/content-blocks/CreateController.js"></script>
    <script src="/js/app/services/content-blocks/service.js"></script>
@endsection

@section('content')

<div class="container" ng-controller="CreateController">

    <ol class="breadcrumb">
        <li><a href="{{ url('admin/content-blocks') }}">Content Blocks</a></li>
        <li class="active">Create Content Block</li>
    </ol>


    <div class="row">
        <div class="col-lg-12">
            <h1>Create Content Block</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="form-group">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" ng-model="contentBlock.name" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description" class="control-lable">Description</label>
                    <textarea ng-model="contentBlock.description" id="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="content" class="control-label">Content</label>
                    <textarea ng-model="contentBlock.content" id="content" class="form-control"></textarea>
                </div>

                <button type="button" class="btn btn-primary" id="create">Create</button>
            </form>
        </div>
    </div>
</div>

@endsection