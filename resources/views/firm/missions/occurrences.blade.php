@extends('firm.layout.app')

@section('title') Mission occurrences @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/blog.css") }}'>
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-history fa-1x"></i> Mission Occurrences</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('missions-occurrences', $mission) }}</p>
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
                                                <h5>
                                                    <a href="{{url('firm/missions').'/'.$mission->id.'/details'}}">{{$mission->title}}</a>
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
                                                    @if(count($mission_occurrences) > 0)
{{--                                                        {{dd($mission_occurrences)}}--}}
                                                        @foreach($mission_occurrences as $m_occurrence)
                                                            <div class="col-sm-12">
                                                                    <div class="row " style="margin-bottom: -20px">
                                                                        <div class="col-sm-6">
                                                                            <p><span class="text-primary"><i class="fa fa-user-tie"></i> </span>
                                                                                <a href="{{url('firm/employees').'/'.$m_occurrence->employee->id.'/profile'}}">
                                                                                    {{$m_occurrence->employee->first_name}} {{$m_occurrence->employee->last_name}}
                                                                                </a>
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <p><span class="text-primary"><i class="fa fa-hourglass-start"></i> Date: </span> {{$m_occurrence->start_date? $mission->start_date : "Not defined"}}</p>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    @if($mission->status->id == 5)
                                                                        <div class="row" style="margin-top: 25px; margin-bottom: -20px">
                                                                            <div class="col-sm-6">
                                                                                <p><span class="text-primary"><i class="fa fa-history"></i> Scheduled Date: </span> {{$m_occurrence->scheduled_date? $m_occurrence->scheduled_date : "Not defined"}}</p>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <p><span class="text-primary"><i class="fa fa-info"></i> Reason: </span> {{$m_occurrence->ReasonId? $m_occurrence->ReasonId : "Not defined"}}</p>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                    @endif
                                                                    <p><span class="text-primary"><i class="fa fa-comment-alt"></i> Comment:</span> {{ $m_occurrence->comment ? $m_occurrence->comment : "No comments" }}</p>
                                                                </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-center m-auto">No mission occurrences yet</p>
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