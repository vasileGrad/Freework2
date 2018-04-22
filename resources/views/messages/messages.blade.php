@extends('main')

@section('title', '| Messages')

@section('content')

<div class="container col-md-12">
    <div class="row" id="app">
    	<div class="col-md-12 col-sm-12">
        	<div id="navigation" class="col-md-3 col-sm-3 mess-color ">
        		<h3 align="center">Messenger<abbr title="Create New Conversation"><a href="{{ route('newMessage') }}"><i class="glyphicon glyphicon-edit pull-right"></i></a></abbr></h3><br>
                <ul v-for="privateMsg in privateMsgs">
                    <li @click="messages(privateMsg.id)" class="row privateMsg">
                        <div class="col-md-3 pull-left">
                            <img :src="'../images/profile/' + privateMsg.image" class="image-privateMsg"/>
                        </div>

                        <div class="col-md-9 pull-left top-message">
                            <b>@{{privateMsg.firstName}} @{{privateMsg.lastName}} @{{privateMsg.conProposal}}</b><br>
                            @{{privateMsg.title}}
                        </div>
                    </li>
                </ul>
        	</div>

        	<div class="col-lg-6 col-sm-4 messages">
                <h3><b>@{{firstNameShow}} @{{lastNameShow}}</b></h3>
                <h5><b>@{{jobTitle}}</b></h5><hr>

        		@include('messages.messenger')

                {{-- <input type="text" v-model="conID"> --}}
                <textarea class="col-md-12 form-control top-textarea" placeholder="Type a message..." v-model="msgFrom" @keydown="inputHandler"></textarea>
        	</div>

        	<div class="col-md-3 col-sm-3 mess-color">
        		<h3 align="center">User Information</h3>
        		<br><hr>

                @if(Session::get('AuthUserRole') === 3)
            		<div class="row">
            			<div class="col-md-2" v-if="currentProposalStatus == 2 && currentProposalStatus !=6 && currentProposalStatus != 7 && currentProposalStatus != 9">
            				<button class="btn btn-primary" id="startContract" @click="startContract()">Start Contract</button><br><br>
            			</div>
            			<div class="col-md-2 center-title" v-if="currentProposalStatus != 2 && currentProposalStatus ==6 && currentProposalStatus != 7 && currentProposalStatus != 9">
                            <button class="btn btn-danger" id="finishContract" @click="finishContract()">Finish Contract</button><br><br>
                        </div>
                        <div class="col-md-2 center-title" v-if="currentProposalStatus != 2 && currentProposalStatus != 6 && currentProposalStatus == 7 && currentProposalStatus != 9">
                            <h3 class="btn btn-success leaveReviewClient"><a href="#" data-toggle="modal" data-target="#myModal1">Leave a Review</a></h3>
                        </div>
                        <div class="col-md-2 center-title" v-if="currentProposalStatus != 2 && currentProposalStatus !=6 && currentProposalStatus != 7 && currentProposalStatus == 9 || currentProposalStatus == 10">
                            <h3 class="btn btn-info leaveTip"><a href="#" data-toggle="modal" data-target="#myModal3">Leave a Tip</a></h3>  
            			</div>
                        <br><br><br><br>

                        <h4 class="padding-left" v-if="currentProposalStatus == 2 && currentProposalStatus != 6 && currentProposalStatus != 7 && currentProposalStatus != 9">Your contract is not started.</h4>

                        <h4 class="padding-left" v-if="currentProposalStatus == 6">Contract in progress.</h4>

                        <h4 class="padding-left" v-if="currentProposalStatus == 7">Please give a review</h4><br>

                        <h4 class="padding-left" v-if="currentProposalStatus == 9 || currentProposalStatus == 10">Show your appreciation to your freelanceer by giving a tip.</h4><br><hr>

                        <h4 class="padding-left" v-if="currentProposalStatus == 11">The freelancer has received your tip.</h4><br><hr>

                        <div v-if="currentProposalStatus != 2 && currentProposalStatus != 6 && currentProposalStatus != 7 && currentProposalStatus == 10" class="padding-left">
                            <h4>You have received a review from the Freelancer!</h4><br>
                            <h4>Rate: <strong>@{{rateFreelancer}}</strong></h4>
                            <h4>Review: <strong>@{{reviewFreelancer}}</strong></h4>
                            <br><hr>
                        </div>
            		</div><br><br>
                @elseif(Session::get('AuthUserRole') === 2)
                    <div class="row">
                        <h4 class="padding-left" v-if="currentProposalStatus == 2 && currentProposalStatus != 6 && currentProposalStatus != 7 && currentProposalStatus != 9">Your contract is not started.</h4>

                        <h4 class="padding-left" v-if="currentProposalStatus != 2 && currentProposalStatus == 6 && currentProposalStatus != 7 && currentProposalStatus != 9">Contract in progress.</h4>

                        <h4 class="padding-left" v-if="currentProposalStatus != 2 && currentProposalStatus != 6 && currentProposalStatus == 7 && currentProposalStatus != 9">Your contract finished successfully!</h4>

                        <div v-if="currentProposalStatus != 2 && currentProposalStatus != 6 && currentProposalStatus != 7 && currentProposalStatus == 9 || currentProposalStatus == 10" class="padding-left">
                            <h4>You have received a review from the Client!</h4><br>
                            <h4>Rate: <strong>@{{rateClient}}</strong></h4>
                            <h4>Review: <strong>@{{reviewClient}}</strong></h4>
                            <br><hr>
                        </div>

                        <div v-if="currentProposalStatus != 2 && currentProposalStatus != 6 && currentProposalStatus != 7 && currentProposalStatus == 9 && currentProposalStatus != 10">
                            <h3 class="btn btn-info leaveReviewFreelancer"><a href="#" data-toggle="modal" data-target="#myModal2"><b>Leave a Review</b></a></h3>
                        </div>

                        <h4 class="padding-left" v-if="currentProposalStatus != 2 && currentProposalStatus != 6 && currentProposalStatus != 7 && currentProposalStatus != 9 && currentProposalStatus == 10">Your have submitted your review successfully!</h4>
                    </div>
                @endif

                <!-- Modal for Freelancer to give review to the Client-->
                <div class="modal fade" id="myModal1" tabindex="-3" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="title">Leave Review for Freelancer</h4>
                            </div>
                            <div class="modal-body">
                                <div class="bodyTitle">
                                    <div class="form-group">
                                        <label for="Rate It">Rate It</label>
                                        <select v-model="rateClient" name="rating" id="rate" class="form-control" >
                                            <option value="5"> 5 </option>
                                            <option value="4"> 4 </option>
                                            <option value="3"> 3 </option>
                                            <option value="2"> 2 </option>
                                            <option value="1"> 1 </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="Tell us more">What was it like working with this Freelancer?</label>
                                        <textarea rows="4" class="form-control" id="review" v-model="reviewClient">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="sendFeedback" data-dismiss="modal" @click="leaveReviewClient()">Send Feedback</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Client to give review to the Freelancer-->
                <div class="modal fade" id="myModal2" tabindex="-3" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="title">Leave Review for Client</h4>
                            </div>
                            <div class="modal-body">
                                <div class="bodyTitle">
                                    <div class="form-group">
                                        <label for="Rate It">Rate It</label>
                                        <select v-model="rateFreelancer" name="rating" id="rate" class="form-control required">
                                            <option value="5"> 5 </option>
                                            <option value="4"> 4 </option>
                                            <option value="3"> 3 </option>
                                            <option value="2"> 2 </option>
                                            <option value="1"> 1 </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="Tell us more">What was it like working with this Client?</label>
                                        <textarea rows="4" class="form-control" id="review" minlength="10" v-model="reviewFreelancer">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="sendFeedback" data-dismiss="modal" @click="leaveReviewFreelancer()">Send Feedback</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for giving a tip to a freelancer-->
                <div class="modal fade" id="myModal3" tabindex="-3" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="title">Leave a Tip</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="Rate It">Show your appreciation to your freelancer by giving a tip.</label>
                                </div>

                                <div class="bodyTitle">
                                    <div class="btn-group btn-group-xl form-inline" data-toggle="buttons">
                                        <input type="radio" id="5" value="5" v-model="valueTip"><b>$5</b>&nbsp;&nbsp;   
                                        <input type="radio" id="10" value="10" v-model="valueTip"><b>$10</b>&nbsp;&nbsp; 
                                        <input type="radio" id="id" value="20" v-model="valueTip"><b>$20</b>&nbsp;&nbsp;  
                                        <input type="text" id="customTip" name="customTip" class="form-control" placeholder="Custom tip" v-model="customTip">
                                        {{-- {!! Form::open() !!}
                                            {{ Form::text('customTip', null, array('class' => 'form-control', 'form-inline', 'placeholder' => 'Custom Tip', 'required' => '', 'numeric', 'min' => '1', 'max' => '1000')) }}
                                        {!! Form::close() !!} --}}
                                    </div>

                                   {{--  <div class="btn-group" role="group" aria-label="Basic example">
                                      <button type="button" class="btn btn-secondary" id="5" name="5" value="5" v-model="valueTip"> $5 </button>
                                      <button type="button" class="btn btn-secondary" id="10" name="10" value="10" v-model="valueTip"> $10 </button>
                                      <button type="button" class="btn btn-secondary" id="id" name="20" value="20" v-model="valueTip"> $20 </button>
                                      <input type="text" name="custom_tip" class="form-control" placeholder="Custom tip" v-model="customTip">
                                    </div> --}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="delete" data-dismiss="modal"> No Thanks </button>
                                <button type="button" class="btn btn-primary" id="tipNow" data-dismiss="modal" @click="leaveTip()"> Tip Now </button>
                            </div>
                        </div>
                    </div>
                </div>
        	</div>
        </div>
    </div>
</div><hr>

@endsection

@section('scripts')
	{{ Html::script('js/moment.min.js') }}
    {{ Html::script('js/selectedUser.js') }}
    {{ Html::script('js/reviewClient.js') }}
@endsection

