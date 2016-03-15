@extends('cccomus-admin.layouts.master')

@section('title', 'Edit User')

@section('styles')
@endsection

@section('scripts')
    <script src="/js/app/controllers/users/EditController.js"></script>
    <script src="/js/app/services/users/service.js"></script>
@endsection

@section('content')

    <div class="container" ng-controller="EditController">

        <ol class="breadcrumb">
            <li><a href="{{ url('admin/users') }}">Users</a></li>
            <li class="active">Edit @{{ user.first_name }} @{{ user.last_name }}</li>
        </ol>

        <div class="row">
            <div class="col-lg-12">
                <h1>Edit @{{ user.first_name }} @{{ user.last_name }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form>
                    <div class="form-group">
                        <label class="control-label">State</label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="user.active" name="active" value="0"> Inactive
                        </label>
                        <label class="radio-inline">
                            <input type="radio" ng-model="user.active" name="active" value="1"> Active
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="first_name" class="control-label">First Name</label>
                        <input type="text" ng-model="user.first_name" id="first_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="control-label">Last Name</label>
                        <input type="text" ng-model="user.last_name" id="last_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" ng-model="user.email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" ng-model="user.username" id="username" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" ng-model="user.password" id="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="control-label">Confirm Password</label>
                        <input type="password" ng-model="user.password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    <button type="button" class="btn btn-primary" ng-click="update(user.user_id)">Update</button>
                </form>
            </div>
        </div>
    </div>

@endsection