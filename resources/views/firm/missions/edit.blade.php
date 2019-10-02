@extends('firm.layout.app')

@section('title') Edit mission @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-project-diagram fa-1x"></i> Edit Mission</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('missions-edit') }}</p>
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
                    <form id="update_form" method="post" action="javascript:void(0)" {{--action="{{ url('firm/missions/'.$mission->id.'/update') }}"--}}>
                        @include('firm.missions.fields')
                        {{--Mission Status field--}}
                        <div class="row clearfix mt-0 mb-3">
                            <div class="col-sm-12">
                                <label for="StatusId" style="margin-bottom: 0">Mission Status</label>
                                <div class="form-control show-tick focused">
                                    <select style="width: 100%" name="StatusId" id="StatusId" class="form-control show-tick js-example-basic-single" tabindex="-98">
                                        <option value="">-- Please select status --</option>
                                        @if($status)
                                            @foreach($status as $st)
                                                <option value="{{$st->id}}"
                                                        @if($mission->StatusId == $st->id) selected
                                                        @elseif($st->id == 1 || $st->id == 2 || $st->id == 4 ) disabled
                                                        @endif>{{ $st->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{--Add Mission Attachments--}}
                    <label for="attachments" style="margin-bottom: 0;">Mission Attachments </label>
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body">
                                    <form action="{{ url('firm/missions/attachments') }}" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
                                        <div class="dz-message">
                                            <div class="drag-icon-cph"> <i class="material-icons">touch_app</i> </div>
                                            <h3>Drop files here or click to upload.</h3>
                                        </div>
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>
                                        <input id="MissionIdInput" type="hidden" name="mission_id" value="{{$mission->id}}" />
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-0 mb-5">
                        <button id="update_btn" type="button" class="btn btn-raised btn-primary m-t-15 waves-effect"><i class="fa fa-save"></i> Save</button>
                        <a href="{{url('firm/missions/index')}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                    </div>

                    {{--Mission Attachments--}}
                    <div class="row clearfix" >
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Mission Attachments</h6>
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

