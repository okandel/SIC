@extends('firm.layout.app')

@section('title') Mission status @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/blog.css") }}'>
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-project-diagram fa-1x"></i> Mission Status Info</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('missions-status', $mission) }}</p>
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
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active">
                                    <div class="container">
                                        {{--Mission--}}
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Mission status info
                                                    @if($mission->StatusId == "1")
                                                        <span class="badge badge-bill badge-success">{{$mission->status->name}}</span>
                                                    @elseif($mission->StatusId == "2")
                                                        <span class="badge badge-bill badge-warning">{{$mission->status->name}}</span>
                                                    @elseif($mission->StatusId == "3")
                                                        <span class="badge badge-bill badge-primary">{{$mission->status->name}}</span>
                                                    @elseif($mission->StatusId == "4")
                                                        <span class="badge badge-bill badge-danger">{{$mission->status->name}}</span>
                                                    @elseif($mission->StatusId == "5")
                                                        <span class="badge badge-bill badge-info">{{$mission->status->name}}</span>
                                                    @endif
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if($missionOccurrence)
                                                    <div class="col-sm-12">
                                                        <div class="row " style="margin-bottom: -20px">
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-tag"></i> </span>
                                                                    <a href="{{url('firm/missions').'/'.$mission->id.'/details'}}">{{$mission->title}}</a>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-user-tie"></i> </span>
                                                                    @if($missionOccurrence->EmpId == null)
                                                                        <a href="{{url('firm/employees').'/'.$mission->employee->id.'/profile'}}">
                                                                            {{$mission->employee->first_name}} {{$mission->employee->last_name}}
                                                                        </a>
                                                                    @else
                                                                        <a href="{{url('firm/employees').'/'.$missionOccurrence->employee->id.'/profile'}}">
                                                                            {{$missionOccurrence->employee->first_name}} {{$missionOccurrence->employee->last_name}}
                                                                        </a>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row" style="margin-top: 25px; margin-bottom: -20px">
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-hourglass-start"></i> Start Date: </span> {{$mission->start_date? $mission->start_date : "Not defined"}}</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-hourglass-end"></i> Complete Date: </span> {{$mission->complete_date? $mission->complete_date : "Not defined"}}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @if($mission->status->id == 5)
                                                            <div class="row" style="margin-top: 25px; margin-bottom: -20px">
                                                                <div class="col-sm-6">
                                                                    <p><span class="text-primary"><i class="fa fa-history"></i> Scheduled Date: </span> {{$missionOccurrence->scheduled_date? $missionOccurrence->scheduled_date : "Not defined"}}</p>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <p><span class="text-primary"><i class="fa fa-info"></i> Reason: </span> {{$missionOccurrence->ReasonId? $missionOccurrence->ReasonId : "Not defined"}}</p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @endif
                                                        <p><span class="text-primary"><i class="fa fa-comment-alt"></i> Comment:</span> {{ $missionOccurrence->comment ? $missionOccurrence->comment : "No comments" }}</p>
                                                    </div>
                                                    @else
                                                        <p class="text-center m-auto">No mission yet</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{--Mission Tasks Occurrences--}}
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Mission Tasks</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if(count($tasksOccurrences) > 0)
                                                        <div class="col-sm-12">
                                                            @foreach($tasksOccurrences as $taskOcc)
                                                                <div class="row " style="margin-bottom: -20px">
                                                                    <div class="col-sm-4">
                                                                        <p><i class="fa fa-th"></i> {{$taskOcc->task->item->name}}</p>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p><i class="fa fa-stream"></i> {{$taskOcc->task->type->name}}</p>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <p>
                                                                            @if($taskOcc->StatusId == 1)
                                                                                <span class="badge badge-pill badge-success">Done</span>
                                                                            @else
                                                                                <span class="badge badge-pill badge-danger">Not done</span>
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-center m-auto">No mission tasks yet</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{--Mission Reps--}}
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Mission Reps</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    @if(count($repsOccurrences) > 0)
                                                        <div class="col-sm-12">
                                                            @foreach($repsOccurrences as $repOcc)
                                                                <div class="row" >
                                                                    <div class="col-sm-3 ">
                                                                        <img style="margin-bottom: -15px" class="img-responsive rounded-circle mt-0" src="{{$repOcc->rep->image}}" width="40px" height="40px" alt="">
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <p><i class="fa fa-tag"></i> {{$repOcc->rep->first_name}} {{$repOcc->rep->last_name}}</p>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <p><i class="fa fa-envelope"></i> {{$repOcc->rep->email}}</p>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <p><i class="fa fa-phone"></i> {{$repOcc->rep->phone}}</p>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-center m-auto">No mission reps yet</p>
                                                    @endif
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
        </div>
    </section>
@endsection