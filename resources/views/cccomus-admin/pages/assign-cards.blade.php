@extends('cccomus-admin.layouts.master')

@section('title', 'Assign/Edit Cards')

@section('styles')
    <link href="/css/app/pages/pages.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/app/controllers/pages/AssignCardsController.js"></script>
    <script src="/js/app/services/pages/service.js"></script>
    <script src="/js/app/services/cards/service.js"></script>
    <script src="/js/vendor/jquery-ui/jquery-ui.min.js"></script>
@endsection

@section('content')

<div class="container" ng-controller="AssignCardsController as crds">

    <ol class="breadcrumb">
        <li><a href="{{ url('admin/pages') }}">Pages</a></li>
        <li class="active">{{ $page->title }} Card Assignment</li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <h1>{{ $page->title }} - Card Assignment</h1>
        </div>
    </div>

    <div class="row" id="cards">
        <div class="col-lg-12">
            <h2>Available Cards</h2>
            <form id="card-menu">
                <select class="form-control" ng-model="card_id" ng-change="selectCard()">
                    <option ng-repeat="(key, value) in cards"
                            value="@{{ key }}"
                            ng-bind-html="value + ' ' + '<strong>...['  + key + ']</strong>'">@{{ value }} [@{{ key }}]</option>
                </select>
            </form>
        </div>
    </div>

    <div class="row" id="assigned-cards">
        <div class="col-lg-12">
            <h2>Assigned Cards (Drag-and-Drop to Reorder)</h2>

            <table ng-table="crds.assignedCardsTableParams" class="table table-condensed table-bordered table-striped">
                <tbody id="sortable">
                <tr ng-repeat="row in $data" ng-model="card_id" id="@{{ row.card_id }}">
                    <td data-title="'Order'">@{{ $index+1 }}</td>
                    <td data-title="'ID'">@{{row.card_id}}</td>
                    <td data-title="'Name'" ng-bind-html="row.name">@{{row.name}}</td>
                    <td data-title="'Actions'"><button type="button" class="btn btn-xs btn-danger" ng-click="unAssignCard(row.card_id)">Remove</button></td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection