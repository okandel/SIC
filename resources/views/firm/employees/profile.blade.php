@extends('firm.layout.app')

@section('title') Employee profile @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/timeline.css") }}'>
@endsection

@section('breadcrumbs')
    <div class="row" style="margin-bottom: -15px">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-user-tie fa-1x"></i> Employee Profile</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('employees-profile') }}</p>
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
                            <img  src="{{$employee->image}}" alt="Client image"> </div>
                    </div>
                    <div class="col-lg-6 col-md-8 col-12">
                        <h4 class="m-t-5 m-b-0">{{$employee->first_name}} {{$employee->last_name}}</h4>
                        <p class="m-t-5 m-b-0">{{$employee->email}}
                            @if($employee->email && $employee->email_verified == 1)
                                <span class="badge badge-success bg-green hidden-sm-down">Verified</span>
                            @else
                                <span class="badge badge-danger bg-red hidden-sm-down">Not verified</span>
                            @endif
                        </p>
                        <p>{{$employee->phone}}
                            @if($employee->phone && $employee->phone_verified == 1)
                                <span class="badge badge-success bg-green hidden-sm-down">Verified</span>
                            @else
                                <span class="badge badge-danger bg-red hidden-sm-down">Not verified</span>
                            @endif
                        </p>
                        <div class="m-t-20">
                            <a href="{{url('firm/employees').'/'.$employee->id.'/edit'}}" class="btn btn-raised btn-info waves-effect"><i class="zmdi zmdi-edit"></i> Edit Profile</a>
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
                                    <p>Scheduled</p>
                                    <h2 class="text-center badge badge-pill badge-success" style="font-size: 25px">{{$new_missions}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center">
                                <div class="body">
                                    <p>Running</p>
                                    <h2 class="text-center badge badge-pill badge-warning" style="font-size: 25px">{{$pending_missions}}</h2>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-6 text-center">
                                <div class="body">
                                    <p>Done</p>
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
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#assets">Assets</a></li>
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
                                                                    <h2><a href="{{url('/firm/missions/'.$mission->id.'/occurance')}}">{{$mission->title}}</a></h2>
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
                                {{--Assets--}}
                                <div role="tabpanel" class="tab-pane" id="assets">
                                    @if(count($assets) > 0)
                                        @foreach($assets as $asset)
                                            <div class="card" style="border: 1px solid #eeeeee">
                                                <div class="card-header">
                                                    <h5>{{$asset->type}}</h5>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <span class="phone">
                                                                <span class="text-primary"><i class="fa fa-car"></i> Brand: </span> {{$asset->brand}}
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span class="phone">
                                                                <span class="text-primary"><i class="fa fa-calendar"></i> Year: </span> {{$asset->year}}
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span class="email">
                                                                <span class="text-primary"><i class="fa fa-hashtag"></i> Number of passengers: </span> {{$asset->no_of_passengers}}
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span class="email">
                                                                <span class="text-primary"><i class="fa fa-info"></i> Body type: </span> {{$asset->body_type}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">No assets yet!</p>
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