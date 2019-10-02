@extends('firm.layout.app')

@section('title') Create mission task @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-tasks fa-1x"></i> Create Mission Task</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('mission-tasks-create', $mission) }}</p>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card">
                    <div class="header">
                        <div class="alert alert-success d-none mt-5" id="msg_success_div">
                            <span id="res_success_message"></span>
                        </div>
                        <div class="alert alert-danger d-none mt-5" id="msg_error_div">
                            <span id="res_error_message"></span>
                        </div>
                        @if ($errors->any())
                            <div class="alert bg-red mt-1">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                    <div class="body">
                        {{--Add Task Data--}}
                        <form id="add_form" method="post" action="javascript:void(0)" {{--action="{{ url('firm/mission/'.$MissionId.'/tasks/store') }}"--}}>
                            @include('firm.missions.tasks.fields')
                        </form>
                        {{--Add Task Attachments--}}
                        <label for="attachments" style="margin-bottom: 0;">Task Attachments </label>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="body">
                                        <form action="{{ url('firm/mission/'.$MissionId.'/tasks/attachments') }}" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
                                            <div class="dz-message">
                                                <div class="drag-icon-cph"> <i class="material-icons">touch_app</i> </div>
                                                <h3>Drop files here or click to upload.</h3>
                                            </div>
                                            <div class="fallback">
                                                <input name="file" type="file" multiple />
                                            </div>
                                            <input id="TaskIdInput" type="hidden" name="task_id" value="" />
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-0 mb-5">
                            <button id="add_btn" type="button" class="btn btn-raised btn-success waves-effect"><i class="fa fa-plus-circle"></i> Add</button>
                            <a href="{{url('firm/mission/'.$MissionId.'/tasks')}}" class="btn btn-raised btn-danger waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


