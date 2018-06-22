@extends('main')

@section('title', '| Edit skill')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 mainUser">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-10">
							<h1>Edit skill</h1>
						</div>
                	</div>
				</div><br><br>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12 ">
							{!! Form::model($skill, ['route' => ['skills.update', $skill->id], 'method' => 'PUT']) !!}
							<div class="col-md-6 col-sm-6">
								{{ Form::label('title', "Skill:") }}
								{{ Form::text('skillName', null, ["class" => 'form-control']) }}
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="row"><br>
									<div class="col-md-6 col-sm-6">
										{!! Html::linkRoute('skills.show', 'Cancel', array($skill->id), array('class' => 'btn btn-danger btn-block')) !!}
									</div>
									<div class="col-md-6 col-sm-6">
										{{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
									</div>
								</div>
							</div>
						{!! Form::close() !!}
						</div>
					</div>
				</div><br><br>
			</div>
		</div>
	</div>
</div>
@endsection

