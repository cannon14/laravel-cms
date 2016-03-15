@extends('cccomus-admin.layouts.master')

@section('title', 'Reviews by Product')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/reviews/IndexController.js" defer></script>
    <script src="/js/app/services/reviews/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController as issuers">

    <div class="row">
        <div class="col-lg-12">
            <h1>Reviews by Products</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="issuers.allIssuersTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Review Count</th>
                    <th>Actions</th>
                </tr>
                <tr class="filters">
                    <td><input type="text" ng-model="filters.cards.card_id"></td>
                    <td><input type="text" ng-model="filters.cards.name"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr ng-repeat="row in $data">
                    <td filter="{products.product_id: 'text'}" sortable="'product_id'">@{{row.card_id}}</td>
                    <td filter="{products.name: 'text'}" sortable="'name'" ng-bind-html="row.name">@{{row.name}}</td>
                    <td>@{{ row.review_count }}</td>
                    <td data-title="'Actions'" >
                        <div class="action-items">
                            <button type="button" ng-click="showReviews(row.product_id)" class="btn btn-primary btn-xs" title="Show Reviews">
                                <span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection