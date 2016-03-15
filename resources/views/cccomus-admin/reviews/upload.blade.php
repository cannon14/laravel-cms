@extends('cccomus-admin.layouts.master')

@section('title', 'Reviews by Product')

@section('styles')
@endsection

@section('scripts')
    <script src="/vendor/dropzone.js" defer></script>
    <script src="/js/app/controllers/reviews/UploadController.js" defer></script>
    <script src="/js/app/services/reviews/service.js" defer></script>
@endsection

@section('content')
    <div class="container" ng-controller="UploadController">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading"><h2>Upload Reviews (CSV File)</h2></div>

                    <div class="panel-body">

                        <div id="actions" class="row">
                            <div class="col-lg-6">
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Add files...</span>
                                </span>
                                <button type="submit" class="btn btn-primary start" id="mass-start">
                                    <i class="glyphicon glyphicon-upload"></i>
                                    <span>Start upload</span>
                                </button>
                                <button type="reset" class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>Cancel upload</span>
                                </button>
                            </div>

                            <div class="col-lg-6">
                                <p><strong>Overall Progress</strong></p>
                                <span class="fileupload-process">
                                  <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                      <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                  </div>
                                </span>
                            </div>
                        </div>

                        <div class="table table-striped files" id="previews">
                            <div id="template" class="file-row">
                                <input type="hidden" value="{{ csrf_token() }}" id="token">
                                <div>
                                    <p><strong>Issuer</strong></p>
                                    <select id="issuer_id">
                                        <option value="">--Select an Issuer--</option>
                                    @foreach($issuers as $key=>$value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div>
                                    <p><strong>Filename</strong></p>
                                    <p class="name" data-dz-name></p>
                                </div>
                                <div>
                                    <p><strong>Size</strong></p>
                                    <p class="size" data-dz-size></p>
                                </div>
                                <div>
                                    <p><strong>Progress</strong></p>
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                    </div>
                                </div>
                                <div>
                                    <p><strong>Actions</strong></p>
                                    <button class="btn btn-primary start file-start">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Start</span>
                                    </button>
                                    <button data-dz-remove class="btn btn-warning cancel">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Cancel</span>
                                    </button>
                                    <button data-dz-remove class="btn btn-danger delete">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Clear</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--panel-body-->

                </div>
                <!--panel-->
            </div>
        </div>
    </div>

@endsection