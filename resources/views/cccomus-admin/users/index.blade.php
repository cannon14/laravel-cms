@extends('cccomus-admin.layouts.master')

@section('title', 'Users')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/users/IndexController.js" defer></script>
    <script src="/js/app/services/users/service.js" defer></script>
@endsection

@section('content')

    <div class="container" ng-controller="IndexController as usr">
        <div class="row">
            <div class="col-lg-6">
                <h1>Users</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="/admin/users/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create User</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form>
                    <div class="form-group">
                        <label class="control-label">State</label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="active" ng-change="filterActive()" name="active" value="0"> Inactive
                        </label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="active" ng-change="filterActive()" name="active" value="1"> Active
                        </label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="active" ng-change="filterActive()" name="active" value="all"> All
                        </label>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                <table ng-table="usr.allUsersTableParams" class="table table-condensed table-bordered">

                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="filters">
                        <td><input type="text" ng-model="filters.users.user_id"></td>
                        <td><input type="text" ng-model="filters.users.first_name"></td>
                        <td><input type="text" ng-model="filters.users.last_name"></td>
                        <td><input type="text" ng-model="filters.acl.role"></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr ng-repeat="row in $data">
                        <td filter="{users.user_id: 'text'}" sortable="'users.user_id'">@{{row.user_id}}</td>
                        <td filter="{users.first_name: 'text'}" sortable="'users.first_name'">@{{ row.first_name }}</td>
                        <td filter="{users.last_name: 'text'}" sortable="'users.last_name'">@{{ row.last_name }}</td>
                        <td filter="{acl.role: 'text'}" sortable="'acl.role'">@{{ row.role }}</td>
                        <td>@{{row.active | status : "Active" : "Inactive"}}</td>

                        <td data-title="'Actions'" >
                            <div class="action-items">
                                <button type="button" ng-click="edit(row.user_id)" class="btn btn-primary btn-xs" title="Edit User">
                                    <span class="glyphicon glyphicon-pencil"></span></button>
                            </div>

                            <div class="action-items">
                                <button type="button" ng-click="delete(row.user_id)" class="btn btn-danger btn-xs" title="Delete User"><span
                                            class="glyphicon glyphicon-remove"></span></button>
                            </div>
                        </td>
                    </tr>
                </table>
                    </div>
            </div>
        </div>
    </div>

@endsection