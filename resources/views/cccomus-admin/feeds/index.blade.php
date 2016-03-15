@extends('cccomus-admin.layouts.master')

@section('title', 'Feeds')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/feeds/IndexController.js" defer></script>
    <script src="/js/app/services/feeds/service.js" defer></script>
@endsection

@section('content')

    <div class="container" ng-controller="IndexController as feeds">
        <div class="row">
            <div class="col-lg-12">
                <h1>Feeds</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <table ng-table="feeds.allFeedsTableParams" class="table table-condensed table-bordered table-striped">
                    <tr ng-repeat="row in $data">
                        <td data-title="'ID'" filter="{feed_id: 'text'}" sortable="'feed_id'">@{{row.feed_id}}</td>
                        <td data-title="'Name'" filter="{name: 'text'}" sortable="'name'" ng-bind-html="row.name"></td>
                        <td data-title="'URL'" filter="{url: 'text'}" sortable="'url'">@{{row.url}}</td>
                        <td data-title="'Key'" filter="{key: 'text'}" sortable="'key'">@{{ row.key}}</td>
                        <td data-title="'Last Updated'" filter="{updated_at: 'text'}" sortable="'updated_at'">@{{row.updated_at}}</td>

                        <td data-title="'Actions'" >
                            <div class="action-items">
                                <button type="button" ng-click="editFeed(row.feed_id)" class="btn btn-primary btn-xs" title="Edit Feed">
                                    <span class="glyphicon glyphicon-pencil"></span></button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection