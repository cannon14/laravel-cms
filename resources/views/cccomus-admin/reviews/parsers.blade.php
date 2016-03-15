@extends('cccomus-admin.layouts.master')

@section('title', 'Reviews by Issuer')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/reviews/ParserController.js" defer></script>
    <script src="/js/app/services/reviews/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="ParserController as parsers">
    <div class="row">
            <div class="col-lg-6">
                <h1>Parsers</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="/admin/reviews/parsers/create" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create Parser</a>
            </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table ng-table="parsers.allParsersTableParams" class="table table-condensed table-bordered table-striped">
                <tr>
                    <th>Parser ID</th>
                    <th>Issuer</th>
                    <th>Columns</th>
                    <th>Actions</th>
                </tr>
                <tr class="filters">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr ng-repeat="row in $data">
                    <td sortable="'_id'">@{{ row.parser_id }}</td>
                    <td sortable="'issuer.name'">@{{row.issuer.name}}</td>
                    <td>@{{row.columns}}</td>
                    <td data-title="'Actions'" >
                        <div class="action-items">
                            <button type="button" ng-click="editParser(row.parser_id)" class="btn btn-primary btn-xs" title="Edit Parser">
                                <span class="glyphicon glyphicon-pencil"></span></button>
                        </div>
                        <div class="action-items">
                            <button type="button" ng-click="deleteParser(row.parser_id)" class="btn btn-danger btn-xs" title="Delete"><span
                                        class="glyphicon glyphicon-remove"></span></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection