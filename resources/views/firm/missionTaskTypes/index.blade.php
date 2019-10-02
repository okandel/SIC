@extends('firm.layout.app')

@section('title') Mission task types @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/datatables.min.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/dataTables.bootstrap.min.css") }}'>
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-stream fa-1x"></i> Mission Task Types</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('mission-task-types') }}</p>
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
                        <form method="get" id="form_types_search">
                            <div class="row clearfix">
                                <div style="margin-left: 30px; margin-top: -25px; width: 20%">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="name" class="form-control">
                                            <label class="form-label">Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-left: 10px; margin-top: -25px; width: 20%">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input min="0" type="number" name="order" class="form-control">
                                            <label class="form-label">Display Order</label>
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
                        <a style="float: right; margin-top: 5px; margin-bottom: 20px" class="btn btn-success" href="{{ url('firm/mission-task-types/create') }}"><i class="fa fa-plus"></i> Add Type</a>
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
                        <table style="width: 1220px;" id="typesData" class="text-center table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Display Order</th>
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

            _name = $('#form_types_search input[name=name]');
            _order = $('#form_types_search input[name=order]');

            typesTable = $('#typesData').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[ 0, "asc" ]],
                // sPaginationType: "full_numbers",
                ajax: {
                    url:"{{ url('/firm/mission-task-types/get-types-data') }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search
                        d.name = _name.val();
                        d._order = _order.val();
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
                        data: 'name', name: 'name',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        data: 'order', name: 'order',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                "<a href='{{url('firm/mission-task-types/')}}/" + oData.id + "/edit' class='btn btn-xs btn-primary' title='Edit'><i class='fa fa-edit'></i></a>  "+
                                "<a href='javascript:' url='{{url('firm/mission-task-types/delete/')}}/" + oData.id + "' onclick='destroy(" + oData.id + ")' id='delete_" + oData.id + "' class='btn btn-xs btn-danger' title='Delete'><i class='fa fa-trash-alt'></i></a>"
                            );
                        }
                    }
                ]
            });

            // Draw table after Filter
            $('#form_types_search').on('submit', function(e) {
                typesTable.draw();
                e.preventDefault();
            });

            // Draw table after Clear
            $('#clear_button').on('click', function(e) {
                _name.val("");
                _order.val("");
                $('#form_types_search').submit();
                check_inputs();
            });

            _name.on("keyup", function () {
                check_inputs();
            });
            _order.on("keyup", function () {
                check_inputs();
            });

            function check_inputs(){
                if (_name.val().length > 0 || _order.val().length >0){
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
