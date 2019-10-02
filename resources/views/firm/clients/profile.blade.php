@extends('firm.layout.app')

@section('title') Client profile @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/timeline.css") }}'>
@endsection

@section('breadcrumbs')
    <div class="row" style="margin-bottom: -15px">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-user-shield fa-1x"></i> Client Profile</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('clients-profile') }}</p>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <section class="profile-page">
        <section class="boxs-simple">
            <div class="profile-header">
                <div class="profile_info row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="profile-image float-md-right"> 
                            <img src="{{$client->image}}" alt="Client image"> </div>
                    </div>
                    <div class="col-lg-6 col-md-8 col-12">
                        <h4 class="m-t-5 m-b-0">{{$client->contact_person}}</h4>
                        <p class="m-t-5 m-b-0">{{$client->email}}</p>
                        <p>{{$client->phone}}</p>
                        <div class="m-t-20">
                            <a href="{{url('firm/clients').'/'.$client->id.'/edit'}}" class="btn btn-raised btn-info waves-effect"><i class="zmdi zmdi-edit"></i> Edit Profile</a>
                            <button class="btn btn-raised btn-default waves-effect"><i class="zmdi zmdi-email"></i> Message</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="container-fluid mt-2">
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center">
                                <div class="body">
                                    <p>All Missions</p>
                                    <h2 class="text-center badge badge-pill badge-default" style="font-size: 25px">{{count($missions)}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center">
                                <div class="body">
                                    <p>New</p>
                                    <h2 class="text-center badge badge-pill badge-success" style="font-size: 25px">{{$new_missions}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center">
                                <div class="body">
                                    <p>Pending</p>
                                    <h2 class="text-center badge badge-pill badge-warning" style="font-size: 25px">{{$pending_missions}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center">
                                <div class="body">
                                    <p>Completed</p>
                                    <h2 class="text-center badge badge-pill badge-primary" style="font-size: 25px">{{$completed_missions}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center">
                                <div class="body">
                                    <p>Re-arranged</p>
                                    <h2 class="text-center badge badge-pill badge-info" style="font-size: 25px">{{$re_arranged_missions}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center">
                                <div class="body">
                                    <p>Expired</p>
                                    <h2 class="text-center badge badge-pill badge-danger" style="font-size: 25px">{{$expired_missions}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix mt-0">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#missions">Missions</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#branches">Branches</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                {{--Missions--}}
                                <div role="tabpanel" class="tab-pane active" id="missions">
                                    <div class="container-fluid" style="background-color: #EEEEEE;">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <ul class="cbp_tmtimeline" style="margin-top: 15px">
                                                    @if(count($missions) > 0)
                                                        @foreach($missions as $mission)
                                                            <li>
                                                                {{--New missions--}}
                                                                @if($mission->start_date >= date("Y-m-d", time()) )
                                                                    <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defined"}}</span> </time>
                                                                    <div class="cbp_tmicon bg-success"><i class="fa fa-hourglass" style="color: white"></i></div>
                                                                    {{--Pending missions--}}
                                                                @elseif($mission->start_date < date("Y-m-d", time()))
                                                                    <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defined"}}</span> </time>
                                                                    <div class="cbp_tmicon bg-warning"><i class="fa fa-clock" style="color: white"></i></div>
                                                                    {{--Completed missions--}}
                                                                @elseif($mission->StatusId == 3)
                                                                    <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defined"}}</span> </time>
                                                                    <div class="cbp_tmicon bg-primary"><i class="fa fa-calendar-check" style="color: white"></i></div>
                                                                    {{--Re-arranged missions--}}
                                                                @elseif($mission->StatusId == 4)
                                                                    <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defined"}}</span> </time>
                                                                    <div class="cbp_tmicon bg-info"><i class="fa fa-history" style="color: white"></i></div>
                                                                    {{--Canceled missions--}}
                                                                @elseif($mission->StatusId == 5)
                                                                    <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defined"}}</span> </time>
                                                                    <div class="cbp_tmicon bg-danger"><i class="fa fa-calendar-times" style="color: white"></i></div>
                                                                @endif
                                                                <div class="cbp_tmlabel">
                                                                    <h2><a href="{{url('/firm/missions/'.$mission->id.'/occurance')}}">{{$mission->title}}</a> <span><strong> by: </strong><a href="{{url('firm/employees').'/'.$mission->employee->id.'/profile'}}">{{$mission->employee->first_name}}</a></span></h2>
                                                                    <p><strong>Branch: </strong> {{$mission->client_branch->display_name}}</p>
                                                                    <p><strong>Priority: </strong> {{$mission->priority->name}}</p>
                                                                    <p><strong>Start Date: </strong> {{$mission->start_date? $mission->start_date : "Not defined"}}</p>
                                                                    <p><strong>Complete Date: </strong> {{$mission->complete_date? $mission->complete_date : "Not defined"}}</p>
                                                                    <p>{{ $mission->description }}</p>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li>
                                                            <div class="cbp_tmicon "><i class="zmdi zmdi-label"></i></div>
                                                            <div class="cbp_tmlabel">
                                                                <h2>No missions yet</h2>
                                                            </div>
                                                        </li>
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--Branches--}}
                                <div role="tabpanel" class="tab-pane" id="branches">
                                    @if(count($branches) > 0)
                                        @foreach($branches as $branch)
                                            <div class="card" style="border: 1px solid #eeeeee">
                                                <div class="card-header">
                                                    <h5>
                                                        <a href="#">{{$branch->display_name}}</a>
                                                    </h5>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <span class="phone">
                                                                <i class="zmdi zmdi-account"></i> <span>&nbsp; {{$branch->contact_person}}</span>
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span class="phone">
                                                                <i class="zmdi zmdi-phone"></i> <span>&nbsp; {{$branch->phone}}</span>
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span class="email">
                                                                <i class="zmdi zmdi-email"></i> <span>&nbsp; {{$branch->email}}</span>
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-2 action_btn ml-5 mb-3">
                                                            <a href="{{url('firm/client').'/'.$client->id.'/branches/'.$branch->id.'/edit'}}" title="Edit Branch" class="btn btn-default col-green"><i class="zmdi zmdi-edit"></i></a>
                                                            <a href="#" class="btn btn-default" title="Send Email"><i class="zmdi zmdi-email"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    {{--Branche Reps--}}
                                                    <section class="contact">
                                                        <div class="container-fluid">
                                                            <ul class="list-unstyled">
                                                                @if(count($branch->branch_reps) > 0)
                                                                    <h6>The Branch Reps</h6>
                                                                    @foreach($branch->branch_reps as $b_rep)
                                                                        <li class="c_list">
                                                                            <div class="row">
                                                                                <div class="col-lg-5 col-md-5 col-10 ml-5">
                                                                                    <div class="u_name">
                                                                                        <h5 class="c_name">
                                                                                            <a href="#">
                                                                                                {{$b_rep->first_name}} {{$b_rep->last_name}}
                                                                                            </a>
                                                                                        </h5>
                                                                                        <span class="phone">
                                                                                            <i class="zmdi zmdi-phone"></i>{{$b_rep->phone}}
                                                                                            @if($b_rep->phone && $b_rep->phone_verified == 1)
                                                                                                <span class="badge badge-success bg-green hidden-sm-down">Verified</span>
                                                                                            @else
                                                                                                <span class="badge badge-danger bg-red hidden-sm-down">Not verified</span>
                                                                                            @endif
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-5 col-md-6 col-12 hidden-sm-down">
                                                                                    <span class="email">
                                                                                        <i class="zmdi zmdi-email"></i> {{$b_rep->email}}
                                                                                        @if($b_rep->email && $b_rep->email_verified == 1)
                                                                                            <span class="badge badge-success bg-green hidden-sm-down">Verified</span>
                                                                                        @else
                                                                                            <span class="badge badge-danger bg-red hidden-sm-down">Not verified</span>
                                                                                        @endif
                                                                                    </span>
                                                                                    <address>
                                                                                        <i class="zmdi zmdi-pin"></i>{{$b_rep->position?$b_rep->position:'Not defined'}}
                                                                                    </address>
                                                                                </div>
                                                                            </div>
                                                                            <div class="action_btn">
                                                                                <a href="{{url('firm/client').'/'.$client->id.'/reps/'.$b_rep->id.'/edit'}}" title="Edit Rep" class="btn btn-default col-green"><i class="zmdi zmdi-edit"></i></a>
                                                                                <a href="#" class="btn btn-default" title="Send Email"><i class="zmdi zmdi-email"></i></a>
                                                                            </div>
                                                                        </li>
                                                                        <hr>
                                                                    @endforeach

                                                                @else
                                                                    <p class="text-center">The branch have no Reps</p>
                                                                @endif
                                                            </ul>

                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">No branches yet!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{'/assets/bundles/knob.bundle.js'}}"></script> <!-- Jquery Knob Plugin Js -->
    <script src="{{'/assets/js/pages/charts/jquery-knob.js'}}"></script>
@endsection