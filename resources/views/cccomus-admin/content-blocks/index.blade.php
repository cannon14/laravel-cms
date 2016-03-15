@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/content-blocks/IndexController.js" defer></script>
    <script src="/js/app/services/content-blocks/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController as contentBlocks">
    <div class="row">
        <div class="col-lg-6">
            <h1>Content Blocks</h1>
        </div>
        <div class="col-lg-6 text-right">
            <a href="/admin/content-blocks/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create Content Block</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="contentBlocks.allContentBlocksTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <tr class="filters">
                    <td><input type="text" ng-model="filters.content_blocks.content_block_id"></td>
                    <td><input type="text" ng-model="filters.content_blocks.name"></td>
                    <td><input type="text" ng-model="filters.content_blocks.description"></td>
                </tr>
                <tr ng-repeat="row in $data">
                    <td filter="{content_blocks.content_block_id: 'text'}" sortable="'content_block_id'">@{{row.content_block_id}}</td>
                    <td filter="{content_blocks.name: 'text'}" sortable="'name'">@{{row.name}}</td>
                    <td filter="{content_blocks.description: 'text'}" sortable="'description'">@{{row.description}}</td>
                    <td>
                        <div class="action-items">
                            <button type="button" ng-click="editContentBlock(row.content_block_id)" class="btn btn-primary btn-xs" title="Edit">
                                <span class="glyphicon glyphicon-pencil"></span></button>
                        </div>
                        <div class="action-items">
                            <button type="button" ng-click="deleteContentBlock(row.content_block_id)" class="btn btn-danger btn-xs" title="Delete"><span
                                        class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection