@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/reviews/EditMapController.js" defer></script>
    <script src="/js/app/services/reviews/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="EditMapController">
    <div class="row">
        <div class="col-lg-12">
            <h1>Edit Map</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form>

                <div class="form-group">
                    <label for="product_name" class="control-label">Product Name</label>
                    <input type="text" ng-model="map.product_name" class="form-control">
                </div>

                <div class="form-group">
                    <label for="product_id" class="control-label">Product ID</label>
                    <input type="text" ng-model="map.product_id" class="form-control">
                </div>

                <div class="form-group">
                    <label for="alt_product_id" class="control-label">Alternate Product ID</label>
                    <input type="text" ng-model="map.alt_product_id" class="form-control">
                </div>

                <button type="button" class="btn btn-primary" ng-click="updateMap()">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection