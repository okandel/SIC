@extends('firm.layout.app')

@section('title') Edit mission task @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-tasks fa-1x"></i> Edit Mission Task</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('mission-tasks-edit', $mission, $task) }}</p>
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
                        <div class="alert bg-red mt-2">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="body">
                    {{--Update Task Data--}}
                    <form id="update_form" method="post" action="javascript:void(0)" {{--action="{{ url('firm/mission/'.$MissionId.'/tasks/'.$task->id.'/update') }}"--}}>
                        @include('firm.missions.tasks.fields')
                    </form>
                    {{--Add Task Attachments--}}
                    <label for="attachments" style="margin-bottom: 0; ">Task Attachments </label>
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
                                        <input id="TaskIdInput" type="hidden" name="task_id" value="{{$task->id}}" />
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-0 mb-5">
                        <button id="update_btn" type="button" class="btn btn-raised btn-primary waves-effect"><i class="fa fa-save"></i> Save</button>
                        <a href="{{url('firm/mission/'.$MissionId.'/tasks')}}" class="btn btn-raised btn-danger waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                    </div>

                    {{--Task Attachments--}}
                    <div class="row clearfix" style="margin-top: -20px;">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Task Attachments</h6>
                                </div>
                                <div class="body">
                                    <div class="table-responsive">
                                        <table style="width: 1200px;" id="attachmentsData" class="text-center table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Preview</th>
                                                    <th class="text-center">Mime Type</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                        </table>
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
@endsection
