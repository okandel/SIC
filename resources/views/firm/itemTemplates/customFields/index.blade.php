@extends('firm.layout.app')

@section('title') Template fields @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/datatables.min.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/dataTables.bootstrap.min.css") }}'>
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-tools fa-1x"></i> Item Template Fields</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('item-template-fields', $template) }}</p>
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
                    <div class="body row" style="margin-bottom: -15px">
                        <div class="col-sm-9">
                            <form method="get" id="form_fields_search">
                                <div class="row clearfix">

                                    <div style="margin-left: 30px; margin-top: -25px; width: 20%">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" name="display_name" class="form-control">
                                                <label class="form-label">Display Name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="margin-left: 20px; margin-top: 15px; width: 30%">
                                        <button type="submit" class="btn btn-sm btn-raised btn-primary m-1-15 waves-effect"><i class="fa fa-filter"></i> Filter</button>
                                        <button type="button" class="btn btn-sm btn-raised btn-warning m-1-15 waves-effect" id="clear_button"><i class="fa fa-times"></i> Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2 m-auto">
                            <a style="float: right; margin-top: 5px; margin-bottom: 20px" class="btn btn-success" href="{{ url('firm/item-template/'.$ItemTemplateId.'/custom-fields/create') }}"><i class="fa fa-plus"></i> Add Field</a>
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
                            <table style="width: 1220px;" id="fieldsData" class="text-center table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Display Name</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Options</th>
                                    <th class="text-center">Default Value</th>
                                    <th class="text-center">Is Required</th>
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
    <script src='{{ url("/assets/plugins/jquery-sparkline/jquery.sparkline.js") }}'></script> <!-- Sparkline Plugin Js -->

    <script src='{{ url("/assets/js/datatables.min.js") }}'></script>
    <script src='{{ url("/assets/js/dataTables.bootstrap.min.js") }}'></script>

    <script src='{{ url("/assets/plugins/sweetalert/sweetalert.min.js")}}'></script>
    <script src='{{ url("/assets/plugins/sweetalert/jquery.sweet-alert.custom.js")}}'></script>



    <script>
        $(document).ready(function () {

            d_name = $('#form_fields_search input[name=display_name]');

            fieldsTable = $('#fieldsData').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[ 0, "asc" ]],
                // sPaginationType: "full_numbers",
                ajax: {
                    url:"{{ url('/firm/item-template/'.$ItemTemplateId.'/custom-fields/get-fields-data') }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search
                        d.display_name = d_name.val();
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
                    {
                        data: 'display_name', name: 'display_name',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        data: 'type', name: 'type',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.type === "1"){
                                $(nTd).html(
                                    "String"
                                );
                            } else if(oData.type === "2") {
                                $(nTd).html(
                                    "Number"
                                );
                            } else if(oData.type === "3") {
                                $(nTd).html(
                                    "Decimal"
                                );
                            } else if(oData.type === "4") {
                                $(nTd).html(
                                    "Date"
                                );
                            } else if(oData.type === "5") {
                                $(nTd).html(
                                    "Multi Select"
                                );
                            }

                        }
                    },
                    {
                        data: 'options', name: 'options',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.options){
                                $(nTd).html(
                                    oData.options
                                );
                            } else {
                                $(nTd).html(
                                    "-----"
                                );
                            }

                        }
                    },
                    {
                        data: 'default_value', name: 'default_value',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        data: 'is_required', name: 'is_required',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.is_required === "1"){
                                $(nTd).html(
                                    "Required"
                                );
                            } else {
                                $(nTd).html(
                                    "Not Required"
                                );
                            }

                        }
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                "<a href='{{url('firm/item-template/')}}/"+ {{$ItemTemplateId}} + "/custom-fields/" + oData.id + "/edit' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-edit'></i></a>  "+
                                "<a href='javascript:' url='{{url('firm/item-template/')}}/"+ {{$ItemTemplateId}} + "/custom-fields/" + oData.id + "/delete' onclick='destroy(" + oData.id + ")' id='delete_" + oData.id + "' class='btn btn-xs btn-danger' title='Delete'><i class='fa fa-trash-alt'></i></a>"
                            );
                        }
                    }
                ]
            });

            // Draw table after Filter
            $('#form_fields_search').on('submit', function(e) {
                fieldsTable.draw();
                e.preventDefault();
            });

            // Draw table after Clear
            $('#clear_button').on('click', function(e) {
                d_name.val("");
                $('#form_fields_search').submit();
                check_inputs();
            });

            d_name.on("keyup", function () {
                check_inputs();
            });

            function check_inputs(){
                if (d_name.val().length > 0){
                    $('#clear_button').attr('hidden', false)
                } else {
                    $('#clear_button').attr('hidden', true)
                }
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
