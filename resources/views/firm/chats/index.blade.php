@extends('firm.layout.app')

@section('title') Chats @endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/assets/css/chatapp.css')}}">
@endsection

{{--@section('breadcrumbs')--}}
{{--    <div class="row">--}}
{{--        <div class="col-sm-3">--}}
{{--            <h4 class="ml-4 mt-3"><i class="fa fa-comments fa-1x"></i> Chat</h4>--}}
{{--        </div>--}}
{{--        <div class="col-sm-9">--}}
{{--            <ul class="breadcrumb">--}}
{{--                <li class="breadcrumb-item float-md-right ml-3 mr-4">--}}
{{--                    <p>{{ Breadcrumbs::render('chats') }}</p>--}}
{{--                </li>--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

@section('content')
    <div class="container-fluid chat-app">

        <div class="row clearfix">
            <div class="chat chat_container" id="chat_container">
            </div>
        </div>
        <div id="plist" class="people-list">
            <a href="javascript:void(0);" class="list_btn"><i class="zmdi zmdi-comments"></i></a>
            <div class="card">
                <ul class="nav nav-tabs tab-nav-right" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#people">People</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#groups">Groups</a></li>
                </ul>

                <div class="btn-group" style="left: 35%">
                    <button id="status_btn" type="button" class="btn  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="current_status" status="online">Online</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0);" class="status" status="online">Online</a></li>
                        <li><a href="javascript:void(0);" class="status" status="offline">Offline</a></li>
                    </ul>
                </div>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane slideLeft active" id="people">
                        <ul class="chat-list list-unstyled m-b-0">
                            @foreach(App\FirmLogin::where('id', '!=', session()->get('user_firm')->id)->get() as $user)
                                <li class="clearfix  user sidebar-user-box" uid="{{$user->id}}">
                                    <img src="{{url('/assets/images/xs/avatar1.jpg')}}" alt="avatar" />
                                    <div class="about">
                                        <div class="name">{{ $user->first_name }} {{$user->last_name}}</div>
                                        <div id="status_div" class="status"> <i class="zmdi zmdi-circle user_status user_{{$user->id}}"></i> <span class="status_name"></span> </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

{{--                        <div role="tabpanel" class="tab-pane slideLeft" id="groups">--}}
{{--                            <ul class="chat-list list-unstyled">--}}
{{--                                <li class="clearfix">--}}
{{--                                    <img src="{{url('/assets/images/xs/avatar6.jpg')}}" alt="avatar" />--}}
{{--                                    <div class="about">--}}
{{--                                        <div class="name">PHP Lead</div>--}}
{{--                                        <div class="status">6 People </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                                <li class="clearfix">--}}
{{--                                    <img src="{{url('/assets/images/xs/avatar7.jpg')}}" alt="avatar" />--}}
{{--                                    <div class="about">--}}
{{--                                        <div class="name">UI UX Designer</div>--}}
{{--                                        <div class="status">10 People </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                                <li class="clearfix">--}}
{{--                                    <img src="{{url('/assets/images/xs/avatar8.jpg')}}" alt="avatar" />--}}
{{--                                    <div class="about">--}}
{{--                                        <div class="name">TL Groups</div>--}}
{{--                                        <div class="status">2 People </div>--}}
{{--                                    </div>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
{{--    <script src="{{url('/assets/bundles/mainscripts.bundle.js')}}"></script><!-- Custom Js -->--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
{{--    <script src="{{ url('/assets/js/jquery-1.12.4.min.js') }}"></script>--}}
    <script>
        var user_id = '{{session()->get('user_firm')->id}}';
        var username = '{{session()->get('user_firm')->first_name}} {{session()->get('user_firm')->last_name}}';
        var typingUrl = '{{url('uploads/defaults/typing.gif')}}';
    </script>
    <script src="{{ url('/assets/js/chat-script.js') }}"></script>
    <script>
        $(".list_btn").click(function () {
            $("#plist").toggleClass("open");
            // check_size();
        });

        // function check_size() {
        //     if ($("#plist").hasClass("open")) {
        //         $('.chat-message').css({
        //             'position': 'fixed',
        //             'width': '66%'
        //         })
        //     } else {
        //         $('.chat-message').css({
        //             'position': 'fixed',
        //             'width': '100%'
        //         })
        //     }
        // }
        //
        // $(document).on('load', function () {
        //    check_size();
        // });
        //
        // $(window).on('resize', function(){
        //     check_size();
        // });

    </script>
@endsection

