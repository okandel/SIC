@extends('firm.layout.app')

@section('title') Create template field @endsection

@section('styles')
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href='{{url("/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")}}' rel="stylesheet" />
    <!-- Wait Me Css -->
    <link href='{{url("/assets/plugins/waitme/waitMe.css")}}' rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href='{{url("/assets/plugins/bootstrap-select/css/bootstrap-select.css")}}' rel="stylesheet" />
    <link href='{{url("/assets/css/bootstrap-tagsinput.css")}}' rel="stylesheet" />
    <link rel="stylesheet" href='{{url("/assets/css/select2.min.css")}}' />
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-4">
            <h4 class="ml-4 mt-3"><i class="fa fa-tools fa-1x"></i> Create Item Template Field</h4>
        </div>
        <div class="col-sm-8">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('item-template-fields-create', $template) }}</p>
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
                        <form method="post" action="{{ url('firm/item-template/'.$ItemTemplateId.'/custom-fields/store') }}">
                            @include('firm.itemTemplates.customFields.fields')
                            <button type="submit" class="btn btn-raised btn-success m-t-15 waves-effect"><i class="fa fa-plus-circle"></i> Add</button>
                            <a href="{{url('firm/item-template/'.$ItemTemplateId.'/custom-fields')}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
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

    {{-- Tags input for multi select options --}}
    <script src='{{url("/assets/js/bootstrap-tagsinput.js")}}'></script>

    {{-- JS file for edit & create custom-field --}}
    <script src='{{url("/assets/js/customFields.js")}}'></script>
    <script src='{{url("/assets/js/select2.min.js")}}'></script>

    <script>
        $(document).ready(function () {
            $('select').select2();
        })
    </script>

@endsection