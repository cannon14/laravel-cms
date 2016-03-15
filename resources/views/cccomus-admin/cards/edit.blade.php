@extends('cccomus-admin.layouts.master')

@section('title', 'Edit Card')

@section('styles')
    <link href="/css/app/cards/cards.css" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="/js/app/controllers/cards/EditController.js" defer></script>
    <script src="/js/app/services/cards/service.js" defer></script>
@endsection

@section('content')

<div class="container" ng-controller="EditController">

    <ol class="breadcrumb">
        <li><a href="{{ url('admin/cards') }}">Cards</a></li>
        <li class="active" ng-bind-html="card.name">Edit @{{ card.name }}</li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <h1>Edit <span ng-bind-html="card.name">@{{ card.name }}</span></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <form>
                <div class="form-group">
                <label for="name" class="control-label">Name</label>
                <input type="text" class="form-control" ng-model="card.name">
                </div>

                <div class="form-group">
                <label for="name" class="control-label">Link URL</label>
                <input type="text" class="form-control" ng-model="card.link_url">
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Bullets</label>
                    <textarea class="form-control" id="bullets" ng-model="card.bullets"></textarea>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Image</label>
                    <input type="text" class="form-control" ng-model="card.image">
                </div>

                <div class="form-group">
                    <label for="issuer_id" class="control-label">Issuer ID</label>
                    <input type="text" class="form-control" ng-model="card.issuer_id">
                </div>

                <div class="form-group">
                    <label for="issuer_name" class="control-label">Issuer Name</label>
                    <input type="text" class="form-control" ng-model="card.issuer_name">
                </div>

                <div class="form-group">
                    <label for="advertiser_id" class="control-label">Advertiser ID</label>
                    <input type="text" class="form-control" ng-model="card.advertiser_id">
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Advertiser Name</label>
                    <input type="text" class="form-control" ng-model="card.advertiser_name">
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Network</label>
                    <input type="text" class="form-control" ng-model="card.network">
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr class="table-title-row">
                            <th colspan="11">PURCHASES</th>
                        </tr>
                        <tr class="table-sub-title-row">
                            <th colspan="5">Regular APR</th>
                            <th colspan="6">Intro APR</th>
                        </tr>
                        <tr>
                            <th>APR</th>
                            <th>Display</th>
                            <th>Type</th>
                            <th>MIN</th>
                            <th>MAX</th>
                            <th>APR</th>
                            <th>Display</th>
                            <th>Period Value</th>
                            <th>Period MIN</th>
                            <th>Period Max</th>
                            <th>Period End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" ng-model="card.purchases_reg_apr_value"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_reg_apr_display"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_reg_apr_type"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_reg_apr_min"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_reg_apr_max"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_intro_apr_value"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_intro_apr_display"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_intro_apr_period_value"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_intro_apr_period_min"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_intro_apr_period_max"></td>
                            <td><input type="text" class="form-control" ng-model="card.purchases_intro_apr_period_end_date"></td>

                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead>
                    <tr class="table-title-row">
                        <th colspan="11">BALANCE TRANSFER</th>
                    </tr>
                    <tr class="table-sub-title-row">
                        <th colspan="2">Regular APR</th>
                        <th colspan="6">Intro APR</th>
                    </tr>
                    <tr>
                        <th>APR</th>
                        <th>Display</th>
                        <th>APR</th>
                        <th>Display</th>
                        <th>Period</th>
                        <th>Period MIN</th>
                        <th>Period MAX</th>
                        <th>Period End Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type="text" class="form-control" ng-model="card.bt_reg_apr_value"></td>
                        <td><input type="text" class="form-control" ng-model="card.bt_reg_apr_display"></td>
                        <td><input type="text" class="form-control" ng-model="card.bt_intro_apr_value"></td>
                        <td><input type="text" class="form-control" ng-model="card.bt_intro_apr_display"></td>
                        <td><input type="text" class="form-control" ng-model="card.bt_intro_apr_period_value"></td>
                        <td><input type="text" class="form-control" ng-model="card.bt_intro_apr_period_min"></td>
                        <td><input type="text" class="form-control" ng-model="card.bt_intro_apr_period_max"></td>
                        <td><input type="text" class="form-control" ng-model="card.bt_intro_apr_period_end_date"></td>
                      </tr>
                    </tbody>
                </table>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">Activation Fee Value</label>
                        <input type="text" class="form-control" ng-model="card.activation_fee_value">
                        </div>
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">Activation Fee Display</label>
                        <input type="text" class="form-control" ng-model="card.activation_fee_display">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">ATM Fee Value</label>
                        <input type="text" class="form-control" ng-model="card.atm_fee_value">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">ATM Fee Display</label>
                        <input type="text" class="form-control" ng-model="card.atm_fee_display">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">Signature Trans Fee Value</label>
                        <input type="text" class="form-control" ng-model="card.pin_trans_fee_value">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">Signature Trans Display</label>
                        <input type="text" class="form-control" ng-model="card.pin_trans_fee_display">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">PIN Trans Fee Value</label>
                        <input type="text" class="form-control" ng-model="card.signature_trans_fee_value">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">PIN Trans Display</label>
                        <input type="text" class="form-control" ng-model="card.signature_trans_fee_display">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">Load Fee Value</label>
                        <input type="text" class="form-control" ng-model="card.load_fee_value">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">Load Fee Display</label>
                        <input type="text" class="form-control" ng-model="card.load_fee_display">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">Credit Needed Value</label>
                        <input type="text" class="form-control" ng-model="card.credit_needed_value">
                    </div>
                    <div class="form-group col-xs-6">
                        <label for="name" class="control-label">Credit Needed Display</label>
                        <input type="text" class="form-control" ng-model="card.credit_needed_display">
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="control-label">Slug</label>
                    <input type="text" class="form-control" ng-model="card.slug">
                </div>

                <div class="form-group">
                    <label for="terms_url" class="control-label">Terms URL</label>
                    <input type="text" class="form-control" ng-model="card.terms_url">
                </div>

                <div class="form-group">
                    <label for="text1" class="control-label">Text 1 (For misc usage)</label>
                    <textarea class="form-control" ng-model="card.text1"></textarea>
                </div>

                <div class="form-group">
                    <label for="text2" class="control-label">Text 2 (For misc usage)</label>
                    <textarea class="form-control" ng-model="card.text2"></textarea>
                </div>

                <div class="form-group">
                    <label for="text3" class="control-label">Text 3 (For misc usage)</label>
                    <textarea class="form-control" ng-model="card.text3"></textarea>
                </div>

                <div class="form-group">
                    <label for="review" class="control-label">Review</label>
                    <textarea class="form-control" id="review" ng-model="card.review"></textarea>
                </div>

                <button type="button" class="btn btn-primary" id="updatePageBtn" ng-click="update()">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection