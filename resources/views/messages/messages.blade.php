@extends('main')

@section('title', '| Messages')

@section('content')
<div class="row" id="app">
	<div class="col-md-12 col-sm-12">
    	<div class="col-md-3 col-sm-3" style="background-color: #fff">
    		<h3 align="center">Messenger <abbr title="Create New Conversation"><a href="{{url('/newMessage')}}"><i class="glyphicon glyphicon-edit pull-right"></i></a></abbr></h3>

            <ul v-for="privateMsg in privateMsgs">
                <li @click="messages(privateMsg.id)" style="list-style:none; margin:10px 0px 0px -40px; background-color:#F3F3F3" class="row">
                    <div class="col-md-3 pull-left">
                        <img :src="'../images/profile/' + privateMsg.image" style="width:50px; height:50px; border-radius:50%; margin: 6px 6px 6px 0px"/>
                    </div>

                    <div class="col-md-9 pull-left" style="margin-top:5px">
                        <b>@{{privateMsg.firstName}} @{{privateMsg.lastName}}</b><br>
                        {{-- <p style="font-size:12px">Here we will display message</p> --}}
                        <span class="glyphicon glyphicon-map-marker"></span> @{{ privateMsg.location }}, @{{ privateMsg.country }}
                    </div>
                </li>
            </ul>
    	</div>

    	<div style="background-color: #fff; min-height: 600px; border-left:5px solid #F5F8FA" class="col-lg-6 col-sm-4">
    		<h3 align="center">Messages</h3>

    		<div id="myScroll" style="overflow-y:scroll; overflow-x:hidden; height:410px; background:#fcfcfc; overflow:auto;transform:rotateX(180deg);">
    			<div class="row col-md-12" style="transform:rotateX(-180deg);">
	                <div v-for="singleMsg in singleMsgs">
		                <div v-if="singleMsg.status != 3 && singleMsg.status != 4 && singleMsg.user_from == <?php echo Auth::user()->id; ?>">
		                	{{-- <div style="text-align:center; opacity: 0.5">@{{ moment().calendar() }}</span></div> --}}
		                    <div class="col-md-12" style="margin-top:10px; margin-bottom: 10px">
		                        <img :src="'../images/profile/' + singleMsg.image" style="width:34px; height:34px;border-radius:50%; margin-left:5px" class="pull-right"/>
		                        <div style="float:right; background-color:#0084ff; padding:5px 15px 5px 15px; margin-right:10px; color:#333; border-radius:10px; color:#fff;">
		                             @{{singleMsg.msg}}
		                        </div>
		                    </div>
		                    <p class="pull-right" style="font-size: 12px; opacity: 0.5; margin-top: -10px;margin-right: 64px;">
		                	@{{singleMsg.created_at}}
		                	</p>
		                </div>
		                

		                <div v-else-if="singleMsg.status != 3 && singleMsg.status != 4 && singleMsg.user_from != <?php echo Auth::user()->id; ?>">
		                    <div class="col-md-12 pull-right" style="margin-top:10px; margin-bottom: 10px">
		                        <img :src="'../images/profile/' + singleMsg.image" style="width:34px; height:34px;border-radius:50%" class="pull-left"/>
		                        <div style="float:left; background-color:#F0F0F0; padding: 5px 15px 5px 15px; border-radius:10px; text-align:right; margin-left: 15px;">
		                        	@{{singleMsg.msg}}
		                    	</div>
		                    </div>
		                    <p class="pull-left" style="font-size: 12px; opacity: 0.5; margin-top:-10px; margin-left:64px;">
		                	@{{ singleMsg.created_at }}
		                	</p>
		                </div>

		                <div v-else-if="singleMsg.status == 3">
		                	<div class="col-md-12" style="margin-top:10px; margin-bottom: 10px">
			                	<hr>
			                	<div class="panel panel-info">
								  	<div class="panel-heading" style="color:black; height: 55px;">
								  		<b>{{ucwords(Auth::user()->firstName)}} {{ucwords(Auth::user()->lastName)}}</b> @{{singleMsg.msg}}
										<img :src="'../images/profile/' + singleMsg.image" style="width:34px; height:34px;border-radius:50%" class="pull-right" />
								  	</div>
								  	<div class="panel-body">
								    	<h3><a href="{{ url('jobShow/1') }}">Job title</a></h3>
								    	<h5>Amount paid: <b>&#36; Price</b></h5>
								    	<p class="pull-right">@{{ singleMsg.created_at }}</p>
								  	</div>
								</div>
								<hr>
							</div>
		                </div>
		                <div v-else="singleMsg.status == 4">
		                    <div class="col-md-12" style="margin-top:10px; margin-bottom: 10px">
		                        <hr>
		                        <div class="panel panel-danger">
								  	<div class="panel-heading" style="color:black; height: 55px;">
								  		<b>{{ucwords(Auth::user()->firstName)}} {{ucwords(Auth::user()->lastName)}}</b> @{{singleMsg.msg}}
										<img :src="'../images/profile/' + singleMsg.image" style="width:34px; height:34px;border-radius:50%" class="pull-right" />
								  	</div>
								  	<div class="panel-body">
								    	<h3><a href="{{ url('jobShow/1') }}">Job title</a></h3>
								    	<h5>Amount paid: <b>&#36; Price</b></h5>
								    	<p class="pull-right">@{{ singleMsg.created_at }}</p>
								  	</div>
								</div>
								<hr>
		                    </div>
		                    
		                </div>
	            	</div>
    			</div>
            

            </div>
            
            <input type="text" v-model="conID">
            <textarea class="col-md-12 form-control" placeholder="Type a message..." v-model="msgFrom" @keydown="inputHandler" style="margin-top:15px;"></textarea>
    	</div>

    	<div class="col-md-3 col-sm-3" style="background-color: #fff">
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
