@extends('cccomus-admin.layouts.master')

@section('title', 'Reviews by Issuer')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/reviews/IndexController.js" defer></script>
    <script src="/js/app/services/reviews/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController as maps">
    <div class="row">
            <div class="col-lg-6">
                <h1>Product ID to Alternate Product ID Mappings</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="/admin/reviews/maps/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create Mapping</a>
            </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="maps.allMapsTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>Product Name</th>
                    <th>Product ID</th>
                    <th>Alternate Product ID</th>
                    <th>Actions</th>
                </tr>
                <tr class="filters">
                    <td><input type="text" ng-model="filters.product_id_to_alt_product_id_map.product_name"></td>
                    <td><input type="text" ng-model="filters.product_id_to_alt_product_id_map.product_id"></td>
                    <td><input type="text" ng-model="filters.product_id_to_alt_product_id_map.alt_product_id"></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr ng-repeat="row in $data">
                    <td filter="{product_id_to_alt_product_id_map.name: 'text'}" sortable="'product_name'">@{{row.product_name}}</td>
                    <td filter="{product_id_to_alt_product_id_map.product_id: 'text'}" sortable="'product_id'">@{{row.product_id}}</td>
                    <td filter="{product_id_to_alt_product_id_map.alt_product_id: 'text'}" sortable="'alt_product_id'">@{{row.alt_product_id}}</td>
                    <td data-title="'Actions'" >
                        <div class="action-items">
                            <button type="button" ng-click="editMap(row.map_id)" class="btn btn-primary btn-xs" title="Edit Mapping">
                                <span class="glyphicon glyphicon-pencil"></span></button>
                        </div>
                        <div class="action-items">
                            <button type="button" ng-click="deleteMap(row.map_id)" class="btn btn-danger btn-xs" title="Delete"><span
                                        class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection