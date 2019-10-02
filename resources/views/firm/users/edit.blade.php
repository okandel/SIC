@extends('firm.layout.app')

@section('title') Edit user @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-user-edit fa-1x"></i> Edit User</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('users-edit') }}</p>
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
                    <form id="update_form" method="post" action="{{ url('firm/users/'.$user->id.'/update') }}" enctype="multipart/form-data">
                        @include('firm.users.fields')
                        <button id="update_btn" type="submit" class="btn btn-raised btn-primary m-t-15 waves-effect"><i class="fa fa-save"></i> Save</button>
                        <a href="{{url('firm/users/index')}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection