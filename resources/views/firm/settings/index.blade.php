@extends('firm.layout.app')

@section('title') Settings @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-cog fa-1x"></i> Settings</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('settings') }}</p>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="body">
                    <div class="table-responsive text-center">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th class="text-center col-xs-1">ID</th>
                                    <th class="text-center col-xs-3">Key</th>
                                    <th class="text-center col-xs-7">Value</th>
                                    <th class="text-center col-xs-1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($array_settings as $setting)
                                    <tr > 
                                        <td class="col-xs-1">{!! $setting->id !!}</td> 
                                        <td class="col-xs-3">{!! $setting->key !!}</td>
                                        <td class="col-xs-7">{!! $setting->value !!}</td>
                                        <td class="col-xs-1"><a href='{{route("settings.edit",$setting->id)}}' class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script src='{{ url("/assets/plugins/bootstrap-notify/bootstrap-notify.js") }}'></script> <!-- Bootstrap Notify Plugin Js -->
    <script src='{{ url("/assets/js/pages/ui/notifications.js") }}'></script> <!-- Custom Js -->
    <script src='{{ url("/assets/plugins/jquery-sparkline/jquery.sparkline.js") }}'></script> <!-- Sparkline Plugin Js -->

    <script src='{{ url("/assets/js/datatables.min.js") }}'></script>
    <script src='{{ url("/assets/js/dataTables.bootstrap.min.js") }}'></script>

    <script src='{{ url("/assets/plugins/sweetalert/sweetalert.min.js")}}'></script>
    <script src='{{ url("/assets/plugins/sweetalert/jquery.sweet-alert.custom.js")}}'></script>

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
