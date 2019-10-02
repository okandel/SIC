@extends('firm.layout.app')

@section('title') User profile @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/timeline.css") }}'>
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-user fa-1x"></i> User Profile</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('users-profile') }}</p>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <section class="profile-page">
        <div class="container-fluid mt-2">
            <div class="row clearfix mt-0">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#userDetails">User Details</a></li>
                                <li class="nav-item"><a class="nav-link " data-toggle="tab" href="#missions">Missions</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                {{--User Details--}}
                                <div role="tabpanel" class="tab-pane active" id="userDetails">
                                    <div class="container">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h6><i class="fa fa-tag"></i> {{$user->first_name}} {{$user->last_name}}
                                                            <div class="col-sm-2 float-right action_btn ml-5">
                                                                <a href="{{url('firm/users').'/'.$user->id.'/edit'}}" title="Edit User" class="btn btn-default col-green"><i class="zmdi zmdi-edit"></i></a>
                                                            </div>
                                                        </h6>
                                                        <div class="row mt-5" style="margin-bottom: -20px">
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-tag"></i> First name: </span> {{$user->first_name}}</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-tag"></i> Last name: </span> {{$user->last_name}}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mt-5" style="margin-bottom: -20px">
                                                            <div class="col-sm-12">
                                                                <p><span class="text-primary"><i class="fa fa-envelope"></i> Email: </span> {{ $user->email }}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row mt-5" style="margin-bottom: -20px">
                                                            <div class="col-sm-12">
                                                                <p><span class="text-primary"><i class="fa fa-phone"></i> Phone: </span> {{ $user->phone }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--User Missions--}}
                                <div role="tabpanel" class="tab-pane " id="missions">
                                    <div class="container-fluid" style="background-color: #EEEEEE;">
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <ul class="cbp_tmtimeline" style="margin-top: 15px">
                                                    @if(count($missions) > 0)
                                                        @foreach($missions as $mission)
                                                            <li>
                                                                {{--New missions--}}
                                                                @if($mission->status->id == 1) {{--New--}}
                                                                <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defiend"}}</span> </time>
                                                                <div class="cbp_tmicon bg-success"><i class="fa fa-hourglass" style="color: white"></i></div>
                                                                {{--Pending missions--}}
                                                                @elseif($mission->status->id == 2) {{--Pending--}}
                                                                <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defiend"}}</span> </time>
                                                                <div class="cbp_tmicon bg-warning"><i class="fa fa-clock" style="color: white"></i></div>
                                                                {{--Completed missions--}}
                                                                @elseif($mission->status->id == 3) {{--Completed--}}
                                                                <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defiend"}}</span> </time>
                                                                <div class="cbp_tmicon bg-primary"><i class="fa fa-calendar-check" style="color: white"></i></div>
                                                                {{--Expired missions--}}
                                                                @elseif($mission->status->id == 4) {{--Expired--}}
                                                                <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defiend"}}</span> </time>
                                                                <div class="cbp_tmicon bg-danger"><i class="fa fa-calendar-times" style="color: white"></i></div>
                                                                {{--Re-arranged missions--}}
                                                                @elseif($mission->status->id == 5) {{--Re-arranged--}}
                                                                <time class="cbp_tmtime"><span>{{ $mission->start_date? $mission->start_date->diffForHumans() : "Not defiend"}}</span> </time>
                                                                <div class="cbp_tmicon bg-info"><i class="fa fa-history" style="color: white"></i></div>
                                                                @endif

                                                                <div class="cbp_tmlabel">
                                                                    <h2><a href="{{url('/firm/missions/'.$mission->id.'/details')}}">{{$mission->title}}</a></h2>
                                                                    <p><strong>Employee: </strong>
                                                                        <a href="{{url('firm/employees').'/'.$mission->employee->id.'/profile'}}">
                                                                            {{$mission->employee->first_name}} {{$mission->employee->last_name}}
                                                                        </a>
                                                                    </p>
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
                                                            <div class="cbp_tmicon bg-info"><i class="zmdi zmdi-label"></i></div>
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