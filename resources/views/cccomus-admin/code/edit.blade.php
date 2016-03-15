@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/code/CodeController.js"></script>
    <script src="/js/app/services/code/service.js"></script>
@endsection

@section('content')

<div class="container" ng-controller="CodeController">

    <ol class="breadcrumb">
        <li><a href="{{ url('admin/templates') }}">Templates</a></li>
        <li class="active">Code</li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-success" ng-click="save()">Save</button>
            <a type="button" href="{{ url('admin/templates') }}" class="btn btn-default">Cancel</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form>
                <textarea id="content_editor" ng-model="content_editor"></textarea>
            </form>
        </div>
    </div>
</div>

@endsection