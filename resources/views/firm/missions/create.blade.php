@extends('firm.layout.app')

@section('title') Create mission @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-project-diagram fa-1x"></i> Create Mission</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('missions-create') }}</p>
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
                        <form id="add_form" method="post" action="{{ url('firm/missions/store') }}">
                            @include('firm.missions.fields')
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
                                            <input id="MissionIdInput" type="hidden" name="mission_id" value="" />
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button id="add_btn" type="button" class="btn btn-raised btn-success m-t-15 waves-effect"><i class="fa fa-plus-circle"></i> Add</button>
                        <a href="{{url('firm/missions/index')}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
