@extends('firm.layout.app')

@section('title') Create user @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-user-plus fa-1x"></i> Create User</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('users-create') }}</p>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('header_content')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card">
                    <div class="header">
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
                        <form method="post" id="add_form" action="{{ url('firm/users/store') }}" enctype="multipart/form-data">

                            @include('firm.users.fields')

                            <button type="submit" id="add_btn" class="ml-4 btn btn-raised btn-success m-t-15 waves-effect" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving"><i class="fa fa-plus-circle"></i> Add</button>
                            <a href="{{url('firm/users/index')}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection