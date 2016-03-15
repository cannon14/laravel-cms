@extends('layouts.main')

@section('content')

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h2>API Admin Functions</h2></div>
				<!--panel-heading-->
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-3">
							{!! Form::open(array('url'=>'admin/flush', 'method'=>'GET')) !!}
							{!! Form::submit('Flush Cache', array('class'=>'btn btn-primary btn-block btn-xs')) !!}
							{!! Form::close() !!}
						</div>
						<div class="col-lg-9">
							<p>Flushes all cached API calls.  Cache will be repopulated as database requests are
								made.</p>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3">
							{!! Form::open(array('url'=>'admin/create', 'method'=>'GET')) !!}
							{!!  Form::button('Create API Username/Password',
								array('class'=>'btn btn-primary btn-block btn-xs', 'data-toggle'=>'modal', 'data-target'=>'#createApiUser')) !!}
							{!! Form::close() !!}
						</div>
						<div class="col-lg-9">
							<p>Flushes all cached API calls.  Cache will be repopulated as database requests are
								made.</p>
						</div>
					</div>
				</div>
				<!--panel-body-->
			</div>
			<!--panel-->
		</div>
		<!--col-lg-12-->
	</div><!--row-->

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><h2>Review Manager Admin Functions</h2></div>
				<!--panel-heading-->
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-3">
							{!! Form::open(array('url'=>'admin/disableAll', 'method'=>'GET')) !!}
							{!! Form::submit('Disable All Reviews', array('class'=>'btn btn-primary btn-block btn-xs')) !!}
							{!! Form::close() !!}
						</div>
						<div class="col-lg-9">
							<p>Disables all the reviews.</p>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3">
							{!! Form::open(array('url'=>'admin/enableAll', 'method'=>'GET')) !!}
							{!! Form::submit('Enable All Reviews', array('class'=>'btn btn-primary btn-block btn-xs')) !!}
							{!! Form::close() !!}
						</div>
						<div class="col-lg-9">
							<p>Enables all the reviews.</p>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-3">
							{!! Form::open(array('url'=>'admin/clear', 'method'=>'GET')) !!}
							{!! Form::submit('Clear Job Statuses', array('class'=>'btn btn-primary btn-block btn-xs')) !!}
							{!! Form::close() !!}
						</div>
						<div class="col-lg-9">
							<p>Clears all Job Status/Progress bars on upload page regardless of completion
								percentage.  Primary purpose of this button is to clear jobs that have become hung,
								for whatever reason, prior to achieving 100%.</p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3">
							{!! Form::open(array('url'=>'admin/delete', 'method'=>'GET')) !!}
							{!!  Form::button('Delete Reviews',
								array('class'=>'btn btn-primary btn-block btn-xs', 'data-toggle'=>'modal', 'data-target'=>'#deleteReviews')) !!}
							{!! Form::close() !!}
						</div>
						<div class="col-lg-9">
							<p>Clears all Job Status/Progress bars on upload page regardless of completion
								percentage.  Primary purpose of this button is to clear jobs that have become hung,
								for whatever reason, prior to achieving 100%.</p>
						</div>
					</div>
				</div>
				<!--panel-body-->
			</div>
			<!--panel-->
		</div>
		<!--col-lg-12-->
	</div><!--row-->


	<div id="createApiUser" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Create an API User!</h4>
				</div>
				<div class="modal-body">
						{!! Form::open(array('url'=>'admin/createApiUser', 'method'=>'POST')) !!}
					<div class="form-group">
						{!! Form::label('username', 'Username', array('class'=>'control-label')) !!}
						{!! Form::text('username', '', array('class'=>'form-control')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('password', 'Password', array('class'=>'control-label')) !!}
						{!! Form::password('password', array('class'=>'form-control')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('confirm_password', 'Confirm', array('class'=>'control-label')) !!}
						{!! Form::password('confirm_password', array('class'=>'form-control')) !!}
					</div>
					<div class="form-group">
						{!! Form::submit('Create', array('class'=>'btn btn-primary btn-md')) !!}
					</div>
					{!! Form::close() !!}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div id="deleteReviews" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Delete Reviews!</h4>
				</div>
				<div class="modal-body">
					{!! Form::open(array('url'=>'admin/deleteReviews', 'method'=>'POST')) !!}
					<div class="form-group">
						{!! Form::label('issuer_id', 'Issuer', array('class'=>'control-label')) !!}
						{!! Form::select('issuer_id', $issuers, array('class'=>'form-control')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('product_id', 'Product', array('class'=>'control-label')) !!}
						{!! Form::select('product_id', $products, array('class'=>'form-control')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('start_dtg', 'Start Date', array('class'=>'control-label')) !!}
						<div class="datetimepicker input-append">
							{!! Form::text('start_dtg', Input::old('start_dtg'), array('class'=>'form-control')) !!}
							<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('end_dtg', 'End Date', array('class'=>'control-label')) !!}
						<div class="datetimepicker input-append">
							{!! Form::text('end_dtg', Input::old('end_dtg'), array('class'=>'form-control')) !!}
							<span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
						</div>
					</div>
					<div class="form-group">
						{!! Form::submit('Delete', array('class'=>'btn btn-primary btn-md')) !!}
					</div>
					{!! Form::close() !!}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	{!! HTML::script('libs/moment/moment.js'); !!}
	{!! HTML::script('libs/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); !!}
	{!! HTML::style('libs/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); !!}

	<script>
	$(document).ready(function () {
		$('.datatable').DataTable();

		$('.datetimepicker').datetimepicker({
		format: 'YYYY-MM-D',
		showTime: false,
		language: 'en'
		});
	});
	</script>
@stop