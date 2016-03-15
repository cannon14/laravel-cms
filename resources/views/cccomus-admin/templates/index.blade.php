@extends('cccomus-admin.layouts.master')

@section('title', 'Templates')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/templates/IndexController.js"></script>
    <script src="/js/app/services/templates/service.js"></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController as tmps">
    <div class="row">
        <div class="col-lg-12">
            <h1>Templates</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="tmps.allTemplatesTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Version</th>
                    <th>Actions</th>
                </tr>
                <tr class="filters">
                    <td><input type="text" ng-model="filters.templates.template_id"></td>
                    <td><input type="text" ng-model="filters.templates.name"></td>
                    <td><input type="text" ng-model="filters.templates.type"></td>
                    <td><input type="text" ng-model="filters.templates.description"></td>
                    <td><input type="text" ng-model="filters.templates.version"></td>
                </tr>

                <tr ng-repeat="row in $data">
                    <td filter="{templates.template_id: 'text'}" sortable="'template_id'">@{{row.template_id}}</td>
                    <td filter="{templates.name: 'text'}" sortable="'name'">@{{row.name}}</td>
                    <td filter="{templates.type: 'text'}" sortable="'type'">@{{ row.type }}</td>
                    <td filter="{templates.description: 'text'}" sortable="'description'">@{{ row.description }}</td>
                    <td filter="{templates.version: 'text'}" sortable="'version'">@{{ row.version}}</td>
                    <td>
                        <div class="action-items">
                        <button type="button" ng-click="edit(row.template_id)" class="btn btn-primary btn-xs" title="Assign/Edit Code">Code</button>
                    </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection