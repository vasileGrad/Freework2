
<div id="myScroll">
	<div class="row col-md-12 rotateX">
        <div v-for="singleMsg in singleMsgs">
            <div v-if="singleMsg.status != 3 && singleMsg.status != 4 && singleMsg.user_from == <?php echo Auth::user()->id; ?>">
            	{{-- <div style="text-align:center; opacity: 0.5">@{{ moment().calendar() }}</span></div> --}}
                <div class="col-md-12 margin-top-bottom">
                    <img :src="'../images/profile/' + singleMsg.image" class="pull-right image-privateMsg2"/>
                    <div class="singleMsg-msg-right">
                         @{{singleMsg.msg}}
                    </div>
                </div>
                <p class="pull-right singleMsg-created_at">
            	@{{singleMsg.created_at}}
            	</p>
            </div>
            

            <div v-else-if="singleMsg.status != 3 && singleMsg.status != 4 && singleMsg.user_from != <?php echo Auth::user()->id; ?>">
                <div class="col-md-12 pull-right margin-top-bottom">
                    <img :src="'../images/profile/' + singleMsg.image" class="pull-left image-privateMsg3"/>
                    <div class="singleMsg-msg-left">
                    	@{{singleMsg.msg}}
                	</div>
                </div>
                <p class="pull-left singleMsg-created_at">
            	@{{ singleMsg.created_at }}
            	</p>
            </div>

            <div v-else-if="singleMsg.status == 3">
            	<div class="col-md-12 margin-top-bottom">
                	<hr>
                	<div class="panel panel-info">
					  	<div class="panel-heading color-heading">
					  		<b>{{ucwords(Auth::user()->firstName)}} {{ucwords(Auth::user()->lastName)}}</b> @{{singleMsg.msg}}
							<img :src="'../images/profile/' + singleMsg.image" class="pull-right image-privateMsg3"/>
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
                <div class="col-md-12 margin-top-bottom">
                    <hr>
                    <div class="panel panel-danger">
					  	<div class="panel-heading color-heading">
					  		<b>{{ucwords(Auth::user()->firstName)}} {{ucwords(Auth::user()->lastName)}}</b> @{{singleMsg.msg}}
							<img :src="'../images/profile/' + singleMsg.image" class="pull-right image-privateMsg3" />
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