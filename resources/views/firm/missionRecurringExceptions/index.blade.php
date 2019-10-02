@extends('firm.layout.app')

@section('title') Vacations & Holidays @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/datatables.min.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/dataTables.bootstrap.min.css") }}'>
    <link href='{{url("/assets/css/select2.min.css")}}' rel="stylesheet" />
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-6">
            <h4 class="ml-4 mt-3"><i class="fa fa-exclamation-triangle fa-1x"></i>
                @if($MissionId)
                    <a href="{{url('firm/missions').'/'.\App\Mission::find($MissionId)->id.'/details'}}">{{\App\Mission::find($MissionId)->title}}</a>
                @endif    
                Vacations & Holidays
            </h4>
        </div>
        <div class="col-sm-6">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('mission-recurring-exceptions') }}</p>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<input type="hidden" name="MissionId" value="{{$MissionId}}">
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="body row" style="margin-bottom: -15px">
                    <div class="col-sm-9">
                        <form method="get" id="form_exceptions_search">
                            <div class="row clearfix">
                                {{--Exception type search field--}}
                                <div style="margin-left: 10px; margin-top: -25px; width: 17%">
                                    <div class="form-group form-float">
                                        <label for="exception_type" style="margin-top: 0; margin-bottom: 0">Exception Type</label>
                                        <div style="margin-top: 0" class="btn-group bootstrap-select form-control show-tick focused">
                                            <select style="width: 100%" name="exception_type" id="exception_type" class="js-example-basic-single form-control show-tick" tabindex="-98">
                                                <option value="">-- Select exception type --</option>
                                                <option value="1" >Date</option>
                                                <option value="2" >Days of week</option>
                                                <option value="3" >Days of month</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if(!$MissionId)
                                    {{--Mission search field--}}
                                    <div style="margin-left: 10px; margin-top: -25px; width: 17%">
                                        <div class="form-group form-float">
                                            <label for="MissionId_search" style="margin-top: 0; margin-bottom: 0">Mission</label>
                                            <div style="margin-top: 0" class="btn-group bootstrap-select form-control show-tick focused">
                                                <select name="MissionId_search" id="MissionId_search" class="js-example-basic-single form-control show-tick" tabindex="-98">
                                                    <option value="">-- Select mission --</option>
                                                    @if(count($missions) > 0)
                                                        @foreach($missions as $mission)
                                                            <option value="{{$mission->id}}">{{$mission->title}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div style="margin-left: 20px; margin-top: 27px; width: 30%">
                                    <button type="submit" class="btn btn-sm btn-raised btn-primary m-1-15 waves-effect"><i class="fa fa-filter"></i> Filter</button>
                                    <button type="button" class="btn btn-sm btn-raised btn-warning m-1-15 waves-effect" id="clear_button"><i class="fa fa-times"></i> Clear</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-2 m-auto">
                        <a style="float: right; margin-top: 5px; margin-bottom: 20px" class="btn btn-success" href="{{ url('firm/mission-recurring-exceptions/create').'/'.$MissionId }}"><i class="fa fa-plus"></i> Add Vacation</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix" style="margin-top: -20px;">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="body">
                    <div class="table-responsive">
                        <table style="width: 1220px;" id="exceptionsData" class="text-center table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                @if(!$MissionId)
                                    <th class="text-center">Mission</th>
                                @endif
                                <th class="text-center">Type</th>
                                <th class="text-center">Value</th>
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
@endsection

@section('scripts')
    <script src='{{ url("/assets/plugins/bootstrap-notify/bootstrap-notify.js") }}'></script> <!-- Bootstrap Notify Plugin Js -->
    <script src='{{ url("/assets/js/pages/ui/notifications.js") }}'></script> <!-- Custom Js -->

    <script src='{{ url("/assets/plugins/sweetalert/sweetalert.min.js")}}'></script>
    <script src='{{ url("/assets/plugins/sweetalert/jquery.sweet-alert.custom.js")}}'></script>
    <script src='{{ url("/assets/js/datatables.min.js") }}'></script>
    <script src='{{ url("/assets/js/dataTables.bootstrap.min.js") }}'></script>
    <script src='{{url("/assets/js/select2.min.js")}}'></script>

    <script>
        $(document).ready(function () {

            _type = $('#exception_type');
            _mission = $('#MissionId_search');
            _type.select2({
                placeholder: "Select type",
                allowClear: true
            });
            _mission.select2({
                placeholder: "Select mission",
                allowClear: true
            });

            exceptionsTable = $('#exceptionsData').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[ 0, "asc" ]],
                // sPaginationType: "full_numbers",
                ajax: {
                    url:"{{ url('/firm/mission-recurring-exceptions/get-exceptions-data/'.$MissionId) }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search
                        d.exception_type = _type.val();
                        d.MissionId_search = _mission.val();
                    }
                },
                type: 'GET',
                columns: [
                    {
                        data: 'id', name: 'id',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(oData.id);
                        }
                    },
                    @if(!$MissionId)
                    {
                        data: 'MissionId', name: 'MissionId',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if (oData.MissionId) {
                                $(nTd).html(
                                    '<a href="{{url("firm/missions")}}'+'/'+oData.mission.id+'/details'+'">'+oData.mission.title+'</a>'
                                );
                            } else {
                                $(nTd).html("All");
                            }
                        }
                    },
                    @endif
                    {
                        data: 'exception_type', name: 'exception_type',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if (oData.exception_type == 1) {
                                $(nTd).html("Date");
                            } else if (oData.exception_type == 2) {
                                $(nTd).html("Days of week");
                            } else if (oData.exception_type == 3) {
                                $(nTd).html("Days of month");
                            }
                        }
                    },
                    {
                        data: 'ExceptionValueString', name: 'exception_value',
                        "searchable": true,
                        "sortable": true
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if (oData.mission) {
                                $(nTd).html(
                                    "<a href='{{url('firm/mission-recurring-exceptions/')}}/" + oData.id + "/edit/"+oData.mission.id+"' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-edit'></i></a>  "+
                                    "<a href='javascript:' url='{{url('firm/mission-recurring-exceptions/delete/')}}/" + oData.id + "' onclick='destroy(" + oData.id + ")' id='delete_" + oData.id + "' class='btn btn-xs btn-danger' title='Delete'><i class='fa fa-trash-alt'></i></a>"
                                );
                            } else {
                                $(nTd).html(
                                    "<a href='{{url('firm/mission-recurring-exceptions/')}}/" + oData.id + "/edit' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-edit'></i></a>  "+
                                    "<a href='javascript:' url='{{url('firm/mission-recurring-exceptions/delete/')}}/" + oData.id + "' onclick='destroy(" + oData.id + ")' id='delete_" + oData.id + "' class='btn btn-xs btn-danger' title='Delete'><i class='fa fa-trash-alt'></i></a>"
                                );
                            }
                        }
                    }
                ]
            });

            // Draw table after Filter
            $('#form_exceptions_search').on('submit', function(e) {
                exceptionsTable.draw();
                e.preventDefault();
            });

            // Draw table after Clear
            $('#clear_button').on('click', function(e) {
                _type.prop('selectedIndex',0);
                _mission.prop('selectedIndex',0);
                _type.select2({
                    placeholder: "Select type",
                    allowClear: true
                });
                _mission.select2({
                    placeholder: "Select mission",
                    allowClear: true
                });
                $('#form_exceptions_search').submit();
                check_inputs();
            });

            _type.on("change", function () {
                check_inputs();
            });
            _mission.on("change", function () {
                check_inputs();
            });

            function check_inputs() {
                @if(!$MissionId)
                if (_type.children("option:selected").val() !== '' || _mission.children("option:selected").val() !== '') {
                    $('#clear_button').attr('hidden', false)
                } else {
                    $('#clear_button').attr('hidden', true)
                }
                @else
                if (_type.children("option:selected").val() !== '') {
                    $('#clear_button').attr('hidden', false)
                } else {
                    $('#clear_button').attr('hidden', true)
                }
                @endif
            }
            check_inputs();

        });

        function destroy(id) {
            swal({
                title: "Are you sure?",
                text: "You are about to delete this entity!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete!",
                closeOnConfirm: false
            }, function(){
                swal.close();
                window.location.href = $('#delete_'+id).attr('url');
            });
        }


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
