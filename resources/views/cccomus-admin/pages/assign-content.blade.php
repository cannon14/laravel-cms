@extends('cccomus-admin.layouts.master')

@section('title', 'Assign/Edit Cards')

@section('styles')
    <link href="/js/vendor/jquery-ui/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css">
    <link href="/css/app/pages/pages.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/app/controllers/pages/AssignContentBlockController.js"></script>
    <script src="/js/app/services/pages/service.js"></script>
    <script src="/js/app/services/content-blocks/service.js"></script>
@endsection

@section('content')

<div class="container" ng-controller="AssignContentBlockController as content_blocks">

    <ol class="breadcrumb">
        <li><a href="{{ url('admin/pages') }}">Pages</a></li>
        <li class="active">{{ $page->title }} Content Block Assignment</li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <h1>{{ $page->title }} - Content Assignment</h1>
        </div>
    </div>

    <div class="row" id="content">
        <div class="col-lg-12">
            <h2>Available Content</h2>
            <form id="content-menu">
                <select ng-options="key as value for (key, value) in contentBlocks" ng-model="content_block_id" ng-change="selectContent()" class="form-control"></select>
            </form>
        </div>
    </div>

    <div class="row" id="assigned-content">
        <div class="col-lg-12">
            <h2>Assigned Content</h2>
            <table ng-table="content_blocks.assignedContentBlocksTableParams" class="table table-condensed table-bordered table-striped">
                <tr ng-repeat="row in $data">
                    <td data-title="'ID'" filter="{content_block_id: 'text'}" sortable="'content_block_id'">@{{row.content_block_id}}</td>
                    <td data-title="'Name'" filter="{title: 'text'}" sortable="'name'">@{{row.name}}</td>
                    <td filter="{description: 'text'}" sortable="'description'">@{{row.description}}</td>
                    <td data-title="'Actions'" ><button type="button" class="btn btn-xs btn-danger" ng-click="unassignContentBlock(row.content_block_id)">Remove</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection