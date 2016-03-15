@extends('layouts.main')

@section('content')

<div class="row">
    <div class="col-lg-10">
        <h2>Users</h2>
    </div>
    <div class="col-lg-2 text-right">
        {!! link_to(url('users/create'), 'Add User', array('class'=>'btn btn-primary btn-xs')) !!}
    </div>
</div>
<!--row-->

<div class="row">
    <div class="col-lg-12">
        <table class="table table-hover datatable">
            <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Updated At</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{!! $user->user_id !!}</td>
                    <td>{!! $user->username !!}</td>
                    <td>{!! $user->first_name !!}</td>
                    <td>{!! $user->last_name !!}</td>
                    <td>{!! $user->email !!}</td>
                    <td>{!! $user->updated_at !!}</td>
                    <td>{!! $user->created_at !!}</td>
                    <td>
                        <div class="action_items">
                            {!! Form::open(array('url'=>'users/'.$user->user_id.'/edit', 'method'=>'GET')) !!}
                            {!! Form::submit('Edit', array('class'=>'btn btn-primary btn-xs')) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="action_items">
                            {!! Form::open(array('url'=>'users/'.$user->user_id, 'method'=>'DELETE')) !!}
                            {!! Form::button('Delete', array('class'=>'delete btn btn-primary btn-xs')) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div><!--col-lg-12-->
</div><!--row-->

@endsection

@section('scripts');
<script src="{!! url('assets/js/app/users.js') !!}"></script>
@endsection