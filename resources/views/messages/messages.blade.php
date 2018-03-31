@extends('main')

@section('title', '| Messages')

@section('content')
<div class="row" id="app">
	<div class="col-md-12 col-sm-12">
    	<div class="col-md-3 col-sm-3 mess-color">
    		<h3 align="center">Messenger<abbr title="Create New Conversation"><a href="{{ route('newMessage') }}"><i class="glyphicon glyphicon-edit pull-right"></i></a></abbr></h3>

            <ul v-for="privateMsg in privateMsgs">
                <li @click="messages(privateMsg.id)" class="row privateMsg">
                    <div class="col-md-3 pull-left">
                        <img :src="'../images/profile/' + privateMsg.image" class="image-privateMsg"/>
                    </div>

                    <div class="col-md-9 pull-left top-message">
                        <b>@{{privateMsg.firstName}} @{{privateMsg.lastName}}</b><br>
                        {{-- <p style="font-size:12px">Here we will display message</p> --}}
                        <span class="glyphicon glyphicon-map-marker"></span> @{{ privateMsg.location }}, @{{ privateMsg.country }}
                    </div>
                </li>
            </ul>
    	</div>

    	<div class="col-lg-6 col-sm-4 messages">
    		<h3 align="center">Messages</h3>

    		@include('messages.messenger')
            
           {{--  <input type="text" v-model="conID"> --}}
            <textarea class="col-md-12 form-control top-textarea" placeholder="Type a message..." v-model="msgFrom" @keydown="inputHandler"></textarea>
    	</div>

    	<div class="col-md-3 col-sm-3 mess-color">
    		<h3 align="center">User Information</h3>
    		<hr>
    		<div class="row">
    			<div class="col-md-6">
    				<button class="btn btn-primary" id="startContract" @click="startContract()">Start Contract</button>
    			</div>
    			<div class="col-md-6">
    				<button class="btn btn-danger" id="finishContract" @click="finishContract()">Finish Contract</button>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@endsection
	
@section('scripts')
	{{ Html::script('js/moment.min.js') }}
@endsection
