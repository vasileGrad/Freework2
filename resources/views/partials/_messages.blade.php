<div class="row">
	<div class="col-md-10 col-md-offset-1 col-sm-12">
		@if (Session::has('success'))

			<div class="alert alert-success" role="alert">
				<strong>Success:</strong> {{ Session::get('success') }}
			</div>

		@endif

		@if (Session::has('errors'))
			@if (count($errors) > 0)
				<div class="alert alert-danger" role="alert">
					<strong>Errors:</strong>
					<ul>
					@foreach ($errors->all() as $error)
						<li> {{ $error }}</li>
					@endforeach
					</ul>
				</div>

			@endif
		@endif
	</div>
</div>
