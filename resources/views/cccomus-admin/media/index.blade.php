@extends('cccomus-admin.layouts.master')

@section('title', 'Reviews by Product')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/media/IndexController.js" defer></script>
    <script src="/js/app/services/media/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="IndexController as medias">

    <div class="row">
        <div class="col-lg-12">
            <h1>Media</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="medias.allMediaTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Filename</th>
                    <th>Actions</th>
                </tr>
                <tr class="filters">
                    <td><input type="text" ng-model="filters.media.media_id"></td>
                    <td></td>
                    <td><input type="text" ng-model="filters.media.name"></td>
                    <td><input type="text" ng-model="filters.media.filename"></td>
                    <td></td>
                </tr>
                <tr ng-repeat="row in $data">
                    <td>@{{row.media_id}}</td>
                    <td><img src="/cccomus-assets/images/@{{row.filename}}" alt="@{{ row.name }}" style="max-width:100px"></td>
                    <td>@{{ row.name}}</td>
                    <td>@{{ row.filename}}</td>
                    <td>
                        <div class="action-items">
                            <button type="button" ng-click="deleteImage(row.media_id)" class="btn btn-danger btn-xs" title="Delete Media">
                                <span class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection