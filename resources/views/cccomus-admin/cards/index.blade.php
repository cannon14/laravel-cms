@extends('cccomus-admin.layouts.master')

@section('title', 'Cards')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/cards/IndexController.js" defer></script>
    <script src="/js/app/services/cards/service.js" defer></script>
@endsection

@section('content')

    <div class="container" ng-controller="IndexController as crds">

        <div class="row">
            <div class="col-lg-12">
                <h1>Cards</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table ng-table="crds.allCardsTableParams" class="table table-condensed table-bordered">
                    <tr>
                        <th>Status</th>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Issuer</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                    <tr class="filters">
                        <td>
                            <select ng-model="filters.cards.active" class="form-control">
                                <option value="1" ng-selected>Active</option>
                                <option value="0">In-active</option>
                            </select>
                        </td>
                        <td></td>
                        <td><input type="text" ng-model="filters.cards.card_id"></td>
                        <td><input type="text" ng-model="filters.cards.name"></td>
                        <td><input type="text" ng-model="filters.cards.issuer_name"></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr ng-repeat="row in $data" ng-class="{'bg-danger': row.active==0}">
                        <td filter="{cards.active}" sortable="'active'">@{{row.active == "1" | status : "Active" : "Inactive"}}</td>
                        <td ng-bind-html="row.image | image"></td>
                        <td filter="{cards.card_id: 'text'}" sortable="'card_id'">@{{row.card_id}}</td>
                        <td filter="{cards.name: 'text'}" sortable="'name'" ng-bind-html="row.name"></td>
                        <td filter="{cards.issuer_name: 'text'}" sortable="'issuer_name'">@{{ row.issuer_name }}</td>
                        <td sortable="'last_updated_on_feed'">@{{row.last_updated_on_feed}}</td>

                        <td data-title="'Actions'" >
                            <div class="action-items">
                                <button type="button" ng-click="edit(row.card_id)" class="btn btn-primary btn-xs" title="Edit Card">
                                    <span class="glyphicon glyphicon-pencil"></span></button>
                            </div>

                            <div class="action-items">
                                <button type="button" ng-click="changeStatus(row.card_id, row.active)" ng-class="{'btn-danger': row.active==0}" class="btn btn-success btn-xs" title="Change Status"><span
                                            ng-class="{'glyphicon-eye-close': row.active==0}" class="glyphicon glyphicon-eye-open"></span></button>
                            </div>

                            <div class="action-items">
                                <button type="button" ng-click="delete(row.card_id)" class="btn btn-danger btn-xs" title="Delete Card"><span
                                            class="glyphicon glyphicon-remove"></span></button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection