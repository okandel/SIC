@extends('firm.layout.app')

@section('title') Edit client branch @endsection

@section('styles')
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href='{{url("/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")}}' rel="stylesheet" />
    <link href='{{url("/assets/css/select2.min.css")}}' rel="stylesheet" />
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-map-marked-alt fa-1x"></i> Edit Client Branch</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('client-branches-edit', $client, $branch) }}</p>
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
                    <form method="post" action="{{ url('firm/client/'.$ClientId.'/branches/'.$branch->id.'/update') }}">

                        @include('firm.clients.branches.fields')

                        <button type="submit" class="btn btn-raised btn-primary m-t-15 waves-effect"><i class="fa fa-save"></i> Save</button>
                        <a href="{{url('firm/client/'.$ClientId.'/branches')}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src='{{ url("/assets/plugins/autosize/autosize.js")}}'></script> <!-- Autosize Plugin Js -->
    <script src='{{ url("/assets/plugins/momentjs/moment.js")}}'></script> <!-- Moment Plugin Js -->
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src='{{url("/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js")}}'></script>

    <script src='{{url("/assets/js/pages/forms/basic-form-elements.js")}}'></script>
    <script src='{{url("/assets/js/select2.min.js")}}'></script>

@endsection

