@extends('firm.layout.app')

@section('title') Create announcement @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-bullhorn fa-1x"></i> Create Announcement</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('announcements-create') }}</p>
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
                        {{--Add announcement data--}}
                        <form id="add_form" method="post" action="{{ url('firm/announcements/store') }}">
                            @include('firm.announcements.fields')
                            <div class="mt-0 mb-5">
                                <button id="add_btn" type="submit" class="btn btn-raised btn-success waves-effect"><i class="fa fa-plus-circle"></i> Add</button>
                                <a href="{{url('firm/announcements/index')}}" class="btn btn-raised btn-danger waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection