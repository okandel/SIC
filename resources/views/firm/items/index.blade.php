@extends('firm.layout.app')

@section('title') Items @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/datatables.min.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/dataTables.bootstrap.min.css") }}'>
    <link rel="stylesheet" href="{{ url("/assets/css/select2.min.css") }}" />
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-th fa-1x"></i> Items</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('items') }}</p>
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
                        <form method="get" id="form_items_search">
                            <div class="row clearfix">

                                <div style="margin-left: 30px; margin-top: -25px; width: 20%">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="name" class="form-control">
                                            <label class="form-label">Name</label>
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
                        <a style="float: right; margin-top: 5px; margin-bottom: 20px" class="btn btn-success" href="{{ url('firm/items/create') }}"><i class="fa fa-plus"></i> Add Item</a>
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
                        <table style="width: 1200px;" id="itemsData" class="text-center table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Description</th>
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
    <script src='{{ url("/assets/js/select2.min.js") }}'></script>

    <script>
        $(document).ready(function () {

            _name = $('#form_items_search input[name=name]');

            itemsTable = $('#itemsData').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[ 0, "asc" ]],
                // sPaginationType: "full_numbers",
                ajax: {
                    url:"{{ url('/firm/items/get-items-data') }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search
                        d.name = _name.val();
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
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                    '<img style="width: 36px; height: 36px" src="'+oData.image+'" data-id="'+oData.id+'" class="img-fluid img-thumbnail">'
                                );

                        }
                    },
                    {
                        data: 'name', name: 'name',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        data: 'description', name: 'description',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                "<a href='{{url('firm/items/')}}/" + oData.id + "/edit' class='btn btn-xs btn-primary waves-effect' title='Edit'><i class='fa fa-edit'></i></a>  "+
                                "<a href='javascript:' url='{{url('firm/items/delete/')}}/" + oData.id + "' onclick='checkHasRelations(" + oData.id + ")' id='delete_" + oData.id + "' class='btn btn-xs btn-danger waves-effect' title='Delete'><i class='fa fa-trash-alt'></i></a>"
                            );
                        }
                    }
                ]
            });

            // Draw table after Filter
            $('#form_items_search').on('submit', function(e) {
                itemsTable.draw();
                e.preventDefault();
            });

            // Draw table after Clear
            $('#clear_button').on('click', function(e) {
                _name.val("");
                $('#form_items_search').submit();
                check_inputs();
            });

            _name.on("keyup", function () {
                check_inputs();
            });

            function check_inputs(){
                if (_name.val().length > 0){
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

        function checkHasRelations(id) {
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
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:'POST',
                    url:'{{("/firm/items/")}}'+id+'/check-has-relations',
                    data: {
                    },
                    success:function(data){
                        if(data.data===true) {
                            alert('Sorry this item has relations and con\'t be deleted');
                        }
                        else if(data.data===false) {
                            window.location.href = $('#delete_'+id).attr('url');
                        }
                        else {
                            console.log( 'data:' , data.data );
                        }
                    },
                    error:function(xhr, status, error){
                        alert('Sorry, Server error happened!');
                        console.log( error );
                    }
                });
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

