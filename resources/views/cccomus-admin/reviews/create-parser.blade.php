@extends('cccomus-admin.layouts.master')

@section('title', 'Page Title')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/reviews/ParserController.js" defer></script>
    <script src="/js/app/services/reviews/service.js" defer></script>
@endsection

@section('content')

    <div class="container" ng-controller="ParserController">
        <div class="row">
            <div class="col-lg-12">
                <h1>Create Parser</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form>
                    <div class="form-group">
                    <label for="issuer_id" class="control-label">Issuer</label>
                    <select class="form-control" ng-model="parser.issuer_id">
                        <option value="">--Select an Issuer--</option>
                        @foreach($issuers as $key=>$value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                        </div>

                    <fieldset data-ng-repeat="parser in parser.data">
                        <div class="form-group">

                            <label for="name" class="control-label col-lg-2 text-right" style="padding-top:8px">Parser Field @{{ $index + 1}}</label>
                            <div class="col-lg-3">
                            <input type="text" ng-model="parser.parser_field" ng-change="parser.database_field = toLowerCase(parser.parser_field)" class="form-control"
                                   placeholder="Enter Parser Field">
                            </div>

                            <label for="name" class="control-label col-lg-2 text-right" style="padding-top:8px">Database Field @{{ $index + 1}}</label>
                            <div class="col-lg-3">
                                <input type="text" ng-model="parser.database_field" class="form-control" disabled>
                            </div>

                            <div class="col-lg-2">
                            <button class="btn btn-danger btn-xs" ng-show="$last" ng-click="removeField()">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                                <button class="btn btn-success btn-xs" ng-show="$last" ng-click="addField()">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </div>
                        </div>

                        <br>
                        <br>
                    </fieldset>

                    <br>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            @{{ parser.data }}
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary" ng-click="createParser()">Create</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection