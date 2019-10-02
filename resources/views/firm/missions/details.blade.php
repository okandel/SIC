@extends('firm.layout.app')

@section('title') Mission details @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/blog.css") }}'>
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-project-diagram fa-1x"></i> Mission Details</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('missions-details') }}</p>
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
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#missions">Mission Details</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tasks">Mission Tasks</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                {{--Mission Details--}}
                                <div role="tabpanel" class="tab-pane active" id="missions">
                                    <div class="container">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <h6><i class="fa fa-tag"></i> {{$mission->title}} <small>by:</small>
                                                            <a href="{{url('/firm/employees/'.$mission->employee->id.'/profile')}}">{{$mission->employee->first_name}} {{$mission->employee->last_name}}</a>

                                                            @if($mission->status->id == 1) {{--New--}}
                                                                <p class='badge badge-bill badge-success'>{{$mission->status->name}}</p>
                                                            @elseif($mission->status->id == 2) {{--Pending--}}
                                                                <p class='badge badge-bill badge-warning'>{{$mission->status->name}}</p>
                                                            @elseif($mission->status->id == 3) {{--Completed--}}
                                                                <a href='{{url('firm/missions/').'/'.$mission->id.'/status'}}' class='badge badge-bill badge-primary'>{{$mission->status->name}}</a>
                                                            @elseif($mission->status->id == 4) {{--Expired--}}
                                                                <p class='badge badge-bill badge-danger'>{{$mission->status->name}}</p>
                                                            @elseif($mission->status->id == 5) {{--Re-arranged--}}
                                                            <a href='{{url('firm/missions/').'/'.$mission->id.'/status'}}' class='badge badge-bill badge-info'>{{$mission->status->name}}</a>
                                                            @endif

                                                            <div class="col-sm-2 float-right action_btn ml-5">
                                                                <a href="{{url('firm/missions').'/'.$mission->id.'/edit'}}" title="Edit Mission" class="btn btn-default col-green"><i class="zmdi zmdi-edit"></i></a>
                                                            </div>
                                                        </h6>
                                                        <div class="row mt-5" style="margin-bottom: -20px">
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-user"></i> Assigned user: </span>
                                                                    <a href="{{url('firm/users').'/'.$mission->assigned_by->id.'/profile'}}">
                                                                        {{$mission->assigned_by->first_name}} {{$mission->assigned_by->last_name}}
                                                                    </a>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-map-marked-alt"></i> Branch: </span> {{$mission->client_branch->display_name}}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row" style="margin-top: 25px; margin-bottom: -20px">
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-sort-amount-up-alt"></i> Priority: </span> {{$mission->priority->name}}</p>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <p><span class="text-primary"><i class="fa fa-hourglass-start"></i> Date: </span> {{$mission->start_date? $mission->start_date : "Not defined"}}</p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <p>{{ $mission->description }}</p>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div  style="background-color: #e9e9e9; width: 2%; height: 92%; margin: 10px auto"></div>
                                                    </div>
                                                    <div class="col-sm-3 text-center">
                                                        <h6>The Mission Attachments</h6>
                                                        @if(count($mission->attachments) > 0)
                                                            @foreach($mission->attachments as $attachment)
                                                                <li class="c_list">
                                                                    <div class="row">
                                                                        <div class="avatar text-center" style="margin-left: 38%">
                                                                            @if($attachment->mime_type == 'image/png' || $attachment->mime_type == 'image/jpg' || $attachment->mime_type == 'image/jpeg')
                                                                                <a href="{{ url('/'.$attachment->attachment_url) }}" target="_blank">
                                                                                    <img src="{{'/'.$attachment->attachment_url}}" style="width: 70px" />
                                                                                </a>
                                                                            @else
                                                                                <img src="{{'/uploads/defaults/attachment.png'}}" style="width: 70px" />
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <hr>
                                                            @endforeach
                                                        @else
                                                            <p style=" margin-bottom: -20px">No attachments</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--Tasks--}}
                                <div role="tabpanel" class="tab-pane" id="tasks">
                                    @if(count($mission->tasks) > 0)
                                        @foreach($mission->tasks as $task)
                                            <div class="card" style="border: 1px solid #eeeeee">
                                                <div class="card-header">
                                                    <div class="row">
                                                        <div class="col-sm-1"></div>
                                                        <div class="col-sm-4">
                                                            <span class="phone">
                                                                <span class="text-primary"><i class="fa fa-th"></i> Item: </span> {{$task->item ? $task->item->name : 'No item'}}
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <span class="phone">
                                                                <span class="text-primary"><i class="fa fa-stream"></i> Type: </span> {{$task->type->name}}
                                                            </span>
                                                        </div>
                                                        <div class="col-sm-2 float-right action_btn ml-5">
                                                            <a href="{{url('firm/mission').'/'.$mission->id.'/tasks/'.$task->id.'/edit'}}" title="Edit Task" class="btn btn-default col-green"><i class="zmdi zmdi-edit"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    {{--Branche Reps--}}
                                                    <section class="contact">
                                                        <div class="container-fluid">
                                                            <ul class="list-unstyled">
                                                                <div class="row">
                                                                    <div class="col-sm-3 text-center">
                                                                        <h6>The Task Attachments</h6>
                                                                        @if(count($task->attachments) > 0)
                                                                            @foreach($task->attachments as $attachment)
                                                                                <li class="c_list">
                                                                                    <div class="row">
                                                                                        <div class="avatar text-center" style="margin-left: 38%">
                                                                                            @if($attachment->mime_type == 'image/png' || $attachment->mime_type == 'image/jpg' || $attachment->mime_type == 'image/jpeg')
                                                                                                <img src="{{'/'.$attachment->attachment_url}}" alt="" />
                                                                                            @else
                                                                                                <img src="{{'/uploads/defaults/attachment.png'}}" alt="" />
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                                <hr>
                                                                            @endforeach
                                                                        @else
                                                                            <p style=" margin-bottom: -20px">No attachments</p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-sm-1">
                                                                        <div  style="background-color: #e9e9e9; width: 2%; height: 92%; margin: 10px auto"></div>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <h6>The Task Item</h6>
                                                                        @if($task->item)
                                                                            <div class="row" style="margin-left: 1px; margin-bottom: -15px">
                                                                                <div class="col-sm-6">
                                                                                    <label for="name">Item Name</label>
                                                                                    <p id="name">{{ $task->item ? $task->item->name : 'No item'}}</p>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <li class="c_list">
                                                                                        <div class="row">
                                                                                            <div class="avatar text-center" style="margin-left: 38%">
                                                                                                @if($task->item->image)
                                                                                                    <img src="{{$task->item->image}}" class="" alt="" />
                                                                                                @else
                                                                                                    <img src="{{'/uploads/defaults/item.png'}}" class="rounded-circle" alt="" />
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </li>
                                                                                </div>
                                                                            </div>
                                                                            <hr style="width: 96%">
                                                                            @if($task->item->item_payload)
                                                                                @include('firm.items._template',['fields' => $task->item->itemTemplate->customFields, 'item' => $task->item,
                                                                                 'item_payload' =>  json_decode($task->item->item_payload, true),
                                                                                 'readonly' => true
                                                                                ])
                                                                            @endif
                                                                        @else
                                                                            <p>No item</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-center">No tasks yet!</p>
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
    <script>
                @if(Session::has('success_message'))
        var msg = '{{ Session::get('success_message') }}' + ' ';
        {{ Session::forget('success_message') }}
        showNotification('bg-green', msg, 'top', 'right', null, null);
                @endif

                @if(Session::has('error_message'))
        var msg = '{{ Session::get('error_message') }}' + ' ';
        {{ Session::forget('error_message') }}
        showNotification('bg-red', msg, 'top', 'right', null, null);
        @endif
    </script>
@endsection
