
<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if($updateMode)
        @include('livewire.update')
    @else
        @include('livewire.create')
    @endif
    @php
        $no = 0;
    @endphp
<table class="table table-bordered mt-5">
    <thead>
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Body</th>
            <th>Category</th>
            <th>Photo</th>
            <th width="150px">Action</th>
        </tr>
    </thead>
    <tbody>
        <label for="search" style="margin: 10px;"> Search </label>
        <form action="">
        <input type="search" placeholder="Search.." name="search" wire:model.debounce.350ms="search">
        </form>
        <label for="filter" style="margin: 10px;"> Category Filter </label>
            <select name="limit" id="" style="margin-top: 15px; margin:5px;" wire:model="byCategory">
                <option value="">Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        <label for="filter" style="margin: 10px;" > Per Page </label>
            <select name="limit" id="" style="margin-top: 15px; margin:5px;" wire:model="perPage">
                <option value="">Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        <label for="filter" style="margin: 10px;" > Sort By </label>
            <select name="limit" id="" style="margin-top: 15px; margin:5px;" wire:model="sortBy">
                <option value="asc">ASC</option>
                <option value="desc">DESC</option>
            </select>
            @if ($posts->count())
                @foreach($posts as $post)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->body }}</td>
                    <td>{{ $post->category }}</td>
                    <td><img src="{{ asset($post->photo) }}"  width="50px"/></td>
                    <td>
                    <button wire:click="edit({{ $post->id }})" class="btn btn-primary btn-sm">Edit</button>
                    <button wire:click="markasread({{ $post->id }})" class="btn btn-danger btn-sm">Delete</button>
                        <a href="/comments" class="btn btn-warning btn-sm">Comments</a>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <div class="alert alert-danger" role="alert">
                    Not Found This Search ' {{$search}} '
                </div>
            </tr>
            @endif
            {{-- {{ $posts->links() }} --}}
    </tbody>
        <div>
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<style>
    a.fa-bell {
  position: relative;
  font-size: 2em;
  color: grey;
  cursor: pointer;
}
span.fa-circle {
  position: absolute;
  font-size: 0.6em;
  top: -4px;
  color: red;
  right: -4px;
}
span.num {
  position: absolute;
  font-size: 0.3em;
  top: 1px;
  color: #fff;
  right: 2px;
}
.chat {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .chat li {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
  }

  .chat li .chat-body p {
    margin: 0;
    color: #777777;
  }

  .panel-body {
    overflow-y: scroll;
    height: 350px;
  }

  ::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar {
    width: 12px;
    background-color: #F5F5F5;
  }

  ::-webkit-scrollbar-thumb {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
  }
</style>
    @auth
        <h1>Notifications</h1>
        <div>
            <p>Notifications go here</p>
        <a class="fa fa-bell" onclick="showDiv()" style="float: right;margin:20px;z-index:999">
        @if (auth()->user()->unreadNotifications->count())
            <span class="fa fa-circle"></span>
            <span class="num">{{auth()->user()->unreadNotifications->count()}}</span>
        @endif
        </a>
        <div id="notif" style="display:none;">
            @if (auth()->user()->unreadNotifications->count())    
                @foreach (auth()->user()->unreadNotifications as $notification)
                            {{$notification->data['name']}}
                            {{$notification->data['content']}} -
                            {{$notification->data['email']}} 
                            <button wire:click="markasread({{ $notification }})" class="btn btn-primary btn-sm"> Mark As Read </button><br> 
                @endforeach
            @else
                <div class="alert alert-danger" role="alert">
                    No Notifications !
                </div>
            @endif
        </div>
        <h1>Chat App</h1>
        <p>Chat go here</p>
        {{-- chat --}}
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Chats</div>
                        {{-- @foreach (Auth::user()->messages()->get() as $item)
                                {{$item->message}}
                        @endforeach 
                        <div class="panel-body">
                            <chat-messages :messages="messages"></chat-messages>
                        </div> --}}
                        <ul class="chat">
                            <li class="left clearfix" v-for="message in messages">
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        @foreach ($messages as $message)
                                                <strong class="primary-font">
                                                    {{$message->user->name}}
                                                </strong>
                                                <p>
                                                    {{$message->message}} 
                                                </p>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="input-group">
                            <input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">
                    
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                                    Send
                                </button>
                            </span>
                        </div>
                        <div class="panel-footer">
                            <chat-form
                                v-on:messagesent="addMessage"
                                :user="{{ Auth::user() }}"
                            ></chat-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- /chat --}}
        @else
            <div>Please <a href="{{route('login')}}">Login</a> To Apply Notifications</div>
        @endauth 
        </div>
        </div>
    </table>
    <script>
        function showDiv(){
                if (document.getElementById('notif').style.display !== "none"){
                    document.getElementById('notif').style.display = "none";
                }else{
                    document.getElementById('notif').style.display = "block";
                }
            }
    </script>
</div>
