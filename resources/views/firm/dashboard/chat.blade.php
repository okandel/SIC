@extends('firm.layout.chat-app')

@section('content')
    @push('css')
        <link href="{{ url('/assets/css/chat-style.css') }}" rel="stylesheet">
    @endpush

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
        <script src="{{ url('/assets/js/jquery-1.12.4.min.js') }}"></script>
        <script>
            var user_id = '{{session()->get('user_firm')->id}}';
            var username = '{{session()->get('user_firm')->first_name}}';
            var typingUrl = '{{url('uploads/defaults/typing.gif')}}';
        </script>
        <script src="{{ url('/assets/js/chat-script.js') }}"></script>
    @endpush

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Chat Control</div>

                <div class="card-body">

                    <div class="dropdown mb-4">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="current_status" status="online">Online</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item status" status="online" href="#">Online</a>
                            <a class="dropdown-item status" status="offline" href="#">Offline</a>
                            <a class="dropdown-item status" status="bys" href="#">Busy</a>
                            <a class="dropdown-item status" status="dnd" href="#">Dont disturb</a>
                        </div>
                    </div>

                    <div id="chat-sidebar">
                        @foreach(App\FirmLogin::where('id', '!=', session()->get('user_firm')->id)->get() as $user)
                            <div id="sidebar-user-box" class="user" uid="{{$user->id}}" >
                                <img width="60px" height="60px" src="{{ url('uploads/defaults/client.png') }}" />
                                <span id="slider-username">{{ $user->first_name }} </span>
                                <span class="user_status user_{{$user->id}} ">&nbsp;</span>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection