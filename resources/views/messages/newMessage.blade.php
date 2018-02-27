@extends('main')

@section('title', '| New Message')

@section('content')

<div class="col-md-12 msgDiv" id="app">

  <div style="background-color:#fff" class="col-md-3 pull-left">

    <div class="row" style="padding:10px">

       <div class="col-md-7"><h3>Freelancers</h3></div>
       <div class="col-md-5 pull-right">
         <a href="{{url('messages')}}" class="btn btn-sm btn-info">All messages</a>@{{conID}}
       </div>
    </div>

   @foreach($freelancers as $freelancer)

   <li @click="friendID({{$freelancer->id}})" v-on:click="seen=true" style="list-style:none;
    margin-top:10px; background-color:#F3F3F3" class="row">

      <div class="col-md-3 pull-left">
           <img src="{{ asset('images/profile/' . $freelancer->image) }}" alt="" style="width:50px; height:50px; border-radius:50%; margin: 6px 6px 6px 0px" />
       </div>

      <div class="col-md-9 pull-left" style="margin-top:5px">
        <b>{{$freelancer->firstName}}</b><br>
        <span class="glyphicon glyphicon-map-marker"></span> {{ $freelancer->location }}, {{ $freelancer->country }}
     </div>
   </li>
   @endforeach
   <hr>
  </div>



    <div class="col-md-6 msg_main">
      <h3 align="center">Messages</h3>
     {{--  <p class="alert alert-success">@{{msg}}</p> --}}

     <div v-if="seen">
        @include('messages.messenger')

        <input type="text" v-model="friend_id">
        <textarea class="col-md-12 form-control" v-model="newMsgFrom"></textarea><br>
        <input type="button" value="send message" @click="sendNewMsg()">
    </div>

  </div>

  <div class="col-md-3 pull-right msg_right">
   <h3 align="center">User Information</h3>
   <hr>
  </div>

</div>


@endsection