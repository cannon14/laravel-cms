@extends('cccomus-admin.layouts.master')

@section('title', 'Pages')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/static-pages/IndexController.js" defer></script>
    <script src="/js/app/services/static-pages/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController as pages">
    <div class="row">
        <div class="col-lg-6">
            <h1>Static Pages</h1>
        </div>
        <div class="col-lg-6 text-right">
            <a href="/admin/static/pages/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create Page</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="pages.allPagesTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>

                <tr ng-repeat="row in $data">
                    <td sortable="'pages.page_id'">@{{row.page_id}}</td>
                    <td sortable="'pages.title'">@{{row.title}}</td>
                    <td sortable="'pages.description'">@{{row.description}}</td>
                    <td>
                        <div class="action-items">
                            <button type="button" ng-click="edit(row.page_id)" class="btn btn-primary btn-xs" title="Edit Page"><span
                                        class="glyphicon glyphicon-pencil"></span></button>
                        </div>

                        <div class="action-items">
                            <button type="button" ng-click="delete(row.page_id)" class="btn btn-danger btn-xs" title="Delete Page"><span
                                        class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection