
<div id="myScroll">
	<div class="row col-md-12 rotateX">
        <div v-for="singleMsg in singleMsgs">
            @if(Session::get('AuthUserRole') == 2)
                <div v-if="singleMsg.status != 6 && singleMsg.status != 7 && singleMsg.user_from == <?php echo Session::get('AuthUser'); ?>">
                    <div class="col-md-12 margin-top-bottom">
                        <img :src="'../images/profile/' + singleMsg.image" class="pull-right image-privateMsg2"/>
                        <div class="singleMsg-msg-right">
                            @{{singleMsg.msg}}
                        </div> 
                    </div>
                    <p class="pull-right singleMsg-right-created_at">
                	@{{singleMsg.created_at}}
                	</p>
                </div>
                
                <div v-else-if="singleMsg.status != 6 && singleMsg.status != 7 && singleMsg.user_from != <?php echo Session::get('AuthUser'); ?>">
                    <div class="col-md-12 pull-right margin-top-bottom">
                        <img :src="'../images/profile/' + singleMsg.image" class="pull-left image-privateMsg3"/>
                        <div class="singleMsg-msg-left">
                        	@{{singleMsg.msg}}
                    	</div>
                    </div>
                    <p class="pull-left singleMsg-left-created_at">
                	@{{ singleMsg.created_at }}
                	</p>
                </div>
                <div v-else-if="singleMsg.status == 6">
                    <div class="col-md-12 margin-top-bottom">
                        <hr>
                        <div class="panel panel-info">
                            <div class="panel-heading color-heading">
                                <b class="margin-left-title">@{{singleMsg.firstName}} @{{singleMsg.lastName}}</b> @{{singleMsg.msg}}
                                <img :src="'../images/profile/' + singleMsg.image" class="pull-left image-privateMsg3"/>
                            </div>
                            <div class="panel-body">
                                <h3>@{{jobTitle}}</h3><br>
                                <h5><b>Price: &#36;@{{singleMsg.payment_amount}}</b></h5>
                                <p class="pull-right">@{{ singleMsg.created_at }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div v-else="singleMsg.status == 7">
                    <div class="col-md-12 margin-top-bottom">
                        <hr>
                        <div class="panel panel-danger">
                            <div class="panel-heading color-heading">
                                <b>@{{singleMsg.firstName}} @{{singleMsg.lastName}}</b> @{{singleMsg.msg}}
                                <img :src="'../images/profile/' + singleMsg.image" class="pull-right image-privateMsg3" />
                            </div>
                            <div class="panel-body">
                                <h3>@{{jobTitle}}</h3>
                                <h5><b>Amount paid: &#36;@{{singleMsg.payment_amount}}</b></h5>
                                <p class="pull-right">@{{ singleMsg.created_at }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            @elseif(Session::get('AuthUserRole') == 3)
                <div v-if="singleMsg.status != 6 && singleMsg.status != 7 && singleMsg.user_from == <?php echo Session::get('AuthUser'); ?>">
                    <div class="col-md-12 margin-top-bottom">
                        <img :src="'../images/profile/' + singleMsg.image" class="pull-right image-privateMsg2"/>
                        <div class="singleMsg-msg-right">
                            @{{singleMsg.msg}}
                        </div> 
                    </div>
                    <p class="pull-right singleMsg-right-created_at">
                    @{{singleMsg.created_at}}
                    </p>
                </div>
                
                <div v-else-if="singleMsg.status != 6 && singleMsg.status != 7 && singleMsg.user_from != <?php echo Session::get('AuthUser'); ?>">
                    <div class="col-md-12 pull-left margin-top-bottom">
                        <img :src="'../images/profile/' + singleMsg.image" class="pull-left image-privateMsg3"/>
                        <div class="singleMsg-msg-left">
                            @{{singleMsg.msg}}
                        </div>
                    </div>
                    <p class="pull-left singleMsg-left-created_at">
                    @{{ singleMsg.created_at }}
                    </p>
                </div>
                <div v-else-if="singleMsg.status == 6">
                    <div class="col-md-12 margin-top-bottom">
                        <hr>
                        <div class="panel panel-info">
                            <div class="panel-heading color-heading">
                                <b>{{ucwords($user->firstName)}} {{ucwords($user->lastName)}}</b> @{{singleMsg.msg}}
                                <img :src="'../images/profile/' + singleMsg.image" class="pull-right image-privateMsg3"/>
                            </div>
                            <div class="panel-body">
                                <h3>@{{jobTitle}}</h3><br>
                                <h5><b>Price: &#36;@{{singleMsg.payment_amount}}</b></h5>
                                <p class="pull-right">@{{ singleMsg.created_at }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div v-else="singleMsg.status == 7">
                    <div class="col-md-12 margin-top-bottom">
                        <hr>
                        <div class="panel panel-danger">
                            <div class="panel-heading color-heading">
                                <b>{{ucwords($user->firstName)}} {{ucwords($user->lastName)}}</b> @{{singleMsg.msg}}
                                <img :src="'../images/profile/' + singleMsg.image" class="pull-right image-privateMsg3" />
                            </div>
                            <div class="panel-body">
                                <h3>@{{jobTitle}}</h3><br>
                                <h5><b>Amount paid: &#36;@{{singleMsg.payment_amount}}</b></h5>
                                <p class="pull-right">@{{ singleMsg.created_at }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            @endif
    	</div>
	</div>
</div>