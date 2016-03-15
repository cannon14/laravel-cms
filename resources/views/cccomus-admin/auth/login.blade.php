@extends('cccomus-admin.layouts.auth')

@section('title', 'Admin Login')

@section('content')
<div class="container-fluid" id="login-container">
	<div class="row" id="login_row">
		<div class="col-lg-4 col-lg-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Please Sign In</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ ucfirst($error) }}</div>
                            @endforeach
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<div class="col-md-12">
								<input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" placeholder="Username">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<button type="submit" class="btn btn-block btn-success" id="login">Login</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--row-->
</div><!--container-->
@endsection
