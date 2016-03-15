@extends('cccomus-admin.layouts.master')

@section('title', 'Categories')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/categories/IndexController.js" defer></script>
    <script src="/js/app/services/categories/service.js" defer></script>
@endsection

@section('content')

    <div class="container" ng-controller="IndexController as categories">
        <div class="row">
            <div class="col-lg-6">
                <h1>Categories</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="/admin/categories/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create Category</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table ng-table="categories.allCategoriesTableParams" class="table table-condensed table-bordered">
                    <tr>
                        <th>Status</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Cards</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="filters">
                        <td>
                            <select ng-model="filters.categories.active" class="form-control">
                                <option value="1" ng-selected>Active</option>
                                <option value="0">In-active</option>
                            </select>
                        </td>
                        <td><input type="text" ng-model="filters.categories.category_id"></td>
                        <td><input type="text" ng-model="filters.categories.name"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr ng-repeat="row in $data">
                        <td filter="{active: 'text'}" sortable="'active'">@{{row.active == "1" | status : "Active" : "Inactive"}}</td>
                        <td filter="{category_id: 'text'}" sortable="'category_id'">@{{row.category_id}}</td>
                        <td filter="{name: 'text'}" sortable="'name'" ng-bind-html="row.name"></td>
                        <td>@{{ row.cards.length }}</td>

                        <td data-title="'Actions'" >
                            <div class="action-items">
                                <button type="button" ng-click="editCategory(row.category_id)" class="btn btn-primary btn-xs" title="Edit Card">
                                    <span class="glyphicon glyphicon-pencil"></span></button>
                            </div>

                            <div class="action-items">
                                <button type="button" ng-click="changeStatus(row.category_id, row.active)" ng-class="{'btn-danger': row.active==0}" class="btn btn-success btn-xs" title="Change Status"><span
                                            ng-class="{'glyphicon-eye-close': row.active==0}" class="glyphicon glyphicon-eye-open"></span></button>
                            </div>

                            <div class="action-items">
                                <button type="button" ng-click="deleteCategory(row.category_id)" class="btn btn-danger btn-xs" title="Delete Category"><span
                                            class="glyphicon glyphicon-remove"></span></button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection