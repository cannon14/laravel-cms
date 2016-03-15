@extends('cccomus-admin.layouts.master')

@section('title', 'Pages')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/pages/IndexController.js" defer></script>
    <script src="/js/app/services/pages/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController as pages">
    <div class="row">
        <div class="col-lg-6">
            <h1>Dynamic Pages</h1>
        </div>
        <div class="col-lg-6 text-right">
            <a href="/admin/pages/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create Page</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="pages.allPagesTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>Status</th>
                    <th>Page ID</th>
                    <th>Title</th>
                    <th>Template</th>
                    <th>Cards</th>
                    <th>Actions</th>
                </tr>
                <tr class="filters">
                    <td>
                        <select ng-model="filters.pages.active" class="form-control">
                            <option value="1" ng-selected>Active</option>
                            <option value="0">In-active</option>
                        </select>
                    </td>
                    <td><input type="text" ng-model="filters.pages.page_id"></td>
                    <td><input type="text" ng-model="filters.pages.title"></td>
                    <td><input type="text" ng-model="filters.templates.name"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr ng-repeat="row in $data">
                    <td sortable="'pages.active'">@{{row.active == "1" | status : "Active" : "Inactive"}}</td>
                    <td filter="{pages.page_id: 'text'}" sortable="'pages.page_id'">@{{row.page_id}}</td>
                    <td filter="{pages.title: 'text'}" sortable="'pages.title'">@{{row.title}}</td>
                    <td filter="{templates.name: 'text'}" sortable="'templates.name'">@{{row.template.name}}</td>
                    <td>@{{ row.category.cards.length }}</td>
                    <td>
                        <div class="action-items">
                            <button type="button" ng-click="edit(row.page_id)" class="btn btn-primary btn-xs" title="Edit">
                                <span class="glyphicon glyphicon-pencil"></span></button>
                        </div>
                        <div class="action-items">
                            <button type="button" ng-click="changeStatus(row.page_id, row.active)" ng-class="{'btn-danger': row.active==0}" class="btn btn-success btn-xs" title="Change Status"><span
                                        ng-class="{'glyphicon-eye-close': row.active==0}" class="glyphicon glyphicon-eye-open"></span></button>
                        </div>
                        <div class="action-items">
                            <button type="button" ng-click="assignCards(row.page_id)" class="btn btn-primary btn-xs" title="Assign/Edit Cards"><span
                                        class="glyphicon glyphicon-credit-card"></span></button>
                        </div>

                        <div class="action-items">
                            <button type="button" ng-click="assignContent(row.page_id)" class="btn btn-primary btn-xs" title="Assign/Edit Content"><span
                                        class="glyphicon glyphicon-th"></span></button>
                        </div>

                        <div class="action-items">
                            <button type="button" ng-click="delete(row.page_id)" class="btn btn-danger btn-xs" title="Delete"><span
                                        class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection