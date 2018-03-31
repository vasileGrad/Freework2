@extends('main')

@section('title', '| New Message')

@section('content')

<div class="col-md-12 msgDiv" id="app">
  <div class="col-md-3 pull-left mess-color">
    <div class="row padding-row">
       <div class="col-md-7"><h3>Freelancers</h3></div>
       <div class="col-md-5 pull-right">
         <a href="{{url('messages')}}" class="btn btn-sm btn-info">All messages</a>@{{conID}}
       </div>
    </div>

     @foreach($users as $user)
       <li @click="friendID({{$user->id}})" v-on:click="seen=true" class="row newMsg-users">

          <div class="col-md-3 pull-left">
               <img src="{{ asset('images/profile/' . $user->image) }}" alt="" class="image-privateMsg"/>
           </div>

          <div class="col-md-9 pull-left top-message">
            <b>{{$user->firstName}}</b><br>
            <span class="glyphicon glyphicon-map-marker"></span> {{ $user->location }}, {{ $user->country }}
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

      {{-- <input type="text" v-model="friend_id"> --}}
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