@extends('firm.layout.app')

@section('title') Create item template @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-file-alt fa-1x"></i> Create Item Template</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('item-templates-create') }}</p>
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
                        <div class="alert alert-success d-none mt-5" id="msg_div">
                            <span id="res_message"></span>
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
                        <form id="add_form" method="post" action="{{ url('firm/item-templates/store') }}" enctype="multipart/form-data">
                            @include('firm.itemTemplates.fields')
                            <button  id="add_btn" type="submit" class="btn btn-raised btn-success m-t-15 waves-effect"><i class="fa fa-plus-circle"></i> Add</button>
                            <a href="{{url('firm/item-templates/index')}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection