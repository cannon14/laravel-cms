@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/issuers/IndexController.js" defer></script>
    <script src="/js/app/services/issuers/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController as issuers">
    <div class="row">
        <div class="col-lg-6">
            <h1>Issuers</h1>
        </div>
        <div class="col-lg-6 text-right">
            <a href="/admin/issuers/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create Issuer</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="issuers.allIssuersTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>Status</th>
                    <th>Logo</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                <tr class="filters">
                    <td>
                        <select ng-model="filters.issuers.active" class="form-control">
                            <option value="1" ng-selected>Active</option>
                            <option value="0">In-active</option>
                        </select>
                    </td>
                    <td></td>
                    <td><input type="text" ng-model="filters.issuers.issuer_id"></td>
                    <td><input type="text" ng-model="filters.issuers.name"></td>
                    <td></td>
                </tr>
                <tr ng-repeat="row in $data">
                    <td filter="{issuers.active: 'text'}" sortable="'active'">@{{row.active == "1" | status : "Active" : "Inactive"}}</td>
                    <td><img src="/cccomus-assets/images/@{{ row.logo }}" alt="@{{ row.name }}"></td>
                    <td filter="{issuers.issuer_id: 'text'}" sortable="'issuer_id'">@{{row.issuer_id}}</td>
                    <td filter="{issuers.name: 'text'}" sortable="'name'">@{{row.name}}</td>

                    <td data-title="'Actions'" >
                        <div class="action-items">
                            <button type="button" ng-click="editIssuer(row.issuer_id)" class="btn btn-primary btn-xs" title="Edit">
                                <span class="glyphicon glyphicon-pencil"></span></button>
                        </div>

                        <div class="action-items">
                            <button type="button" ng-click="changeStatus(row.issuer_id, row.active)" ng-class="{'btn-danger': row.active==0}" class="btn btn-success btn-xs" title="Change Status"><span
                                        ng-class="{'glyphicon-eye-close': row.active==0}" class="glyphicon glyphicon-eye-open"></span></button>
                        </div>

                        <div class="action-items">
                            <button type="button" ng-click="deleteIssuer(row.issuer_id)" class="btn btn-danger btn-xs" title="Delete"><span
                                        class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection