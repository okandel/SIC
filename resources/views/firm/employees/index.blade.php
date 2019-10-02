@extends('firm.layout.app')

@section('title') Employees @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/datatables.min.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/dataTables.bootstrap.min.css") }}'>
    <link rel="stylesheet" href="{{ url("/assets/css/select2.min.css") }}" />
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-user-tie fa-1x"></i> Employees</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('employees') }}</p>
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
                        <form method="get" id="form_employees_search">
                            <div class="row clearfix">

                                <div style="margin-left: 30px; margin-top: -25px; width: 20%">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="first_name" class="form-control">
                                            <label class="form-label">First Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-left: 10px; margin-top: -25px; width: 20%">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="last_name" class="form-control">
                                            <label class="form-label">Last Name</label>
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
                        <a style="float: right; margin-top: 5px; margin-bottom: 20px" class="btn btn-success" href="{{ url('firm/employees/create') }}"><i class="fa fa-plus"></i> Add Employee</a>
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
                        <table style="width: 1200px;" id="employeesData" class="text-center table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Employee Assets</th>
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

            f_name = $('#form_employees_search input[name=first_name]');
            l_name = $('#form_employees_search input[name=last_name]');

            employeesTable = $('#employeesData').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[ 0, "asc" ]],
                // sPaginationType: "full_numbers",
                "bStateSave": true,
                "fnStateSave": function (oSettings, oData) {
                    localStorage.setItem('offersDataTables', JSON.stringify(oData));
                },
                "fnStateLoad": function (oSettings) {
                    return JSON.parse(localStorage.getItem('offersDataTables'));
                },
                ajax: {
                    url:"{{ url('/firm/employees/get-employees-data') }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search
                        d.first_name = f_name.val();
                        d.last_name = l_name.val();
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
                                    '<a href="{{url('firm/employees')}}'+'/' + oData.id + '/profile' +' ">' +
                                    '<img style="width: 36px; height: 36px" src="'+oData.image+'" data-id="'+oData.id+'" class="img-fluid img-thumbnail">' +
                                    '</a>'
                                );

                        }
                    },
                    {
                        data: 'first_name', name: 'first_name',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                '<a href="{{url('firm/employees')}}'+'/' + oData.id + '/profile' +' ">'+oData.first_name+'</a>'
                            );
                        }
                    },
                    {
                        data: 'last_name', name: 'last_name',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                '<a href="{{url('firm/employees')}}'+'/' + oData.id + '/profile' +' ">'+oData.last_name+'</a>'
                            );
                        }
                    },
                    {
                        data: 'email', name: 'email',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        data: 'phone', name: 'phone',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                '<button type="button" data-id="'+oData.id+'" class="btn btn-info btn-xs m-2 waves-effect assets_btn"  ><i class="fa fa-car-alt"></i> Assets</button>' +
                                '<button type="button" data-id="'+oData.id+'" class="btn btn-info btn-xs waves-effect devices_btn"  ><i class="fa fa-mobile-alt"></i> Devices</button>'
                            );
                        }
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                "<a href='{{url('firm/employees/')}}/" + oData.id + "/edit' class='btn btn-xs btn-primary waves-effect' title='Edit'><i class='fa fa-edit'></i></a>  "+
                                "<a href='javascript:' url='{{url('firm/employees/delete/')}}/" + oData.id + "' onclick='checkHasRelations(" + oData.id + ")' id='delete_" + oData.id + "' class='btn btn-xs btn-danger waves-effect' title='Delete'><i class='fa fa-trash-alt'></i></a>"
                            );
                        }
                    }
                ]
            });

            // Draw table after Filter
            $('#form_employees_search').on('submit', function(e) {
                employeesTable.draw();
                e.preventDefault();
            });

            // Draw table after Clear
            $('#clear_button').on('click', function(e) {
                f_name.val("");
                l_name.val("");
                $('#form_employees_search').submit();
                check_inputs();
            });

            f_name.on("keyup", function () {
                check_inputs();
            });
            l_name.on("keyup", function () {
                check_inputs();
            });

            function check_inputs(){
                if (f_name.val().length > 0 || l_name.val().length > 0){
                    $('#clear_button').attr('hidden', false)
                } else {
                    $('#clear_button').attr('hidden', true)
                }
            }
            check_inputs();

            //Get assets
            $(document).on('click', ".assets_btn", function(e) {
                e.preventDefault();
                var ctrl = $(this);
                var id=$(ctrl).attr("data-id");
                var url="{{ url('firm/employees/vehicles') }}" + "/"+id;

                $.ajax({
                    url: url,
                    method:"get",
                    success: function (data) {
                        $('#assetsModal .data').html(data);
                        $('#assetsModal').modal('show');
                    },
                    error:function (err) {
                        console.log(err);
                    }
                })
            });

            //Get devices
            $(document).on('click', ".devices_btn", function(e) {
                e.preventDefault();
                var ctrl = $(this);
                var id=$(ctrl).attr("data-id");
                var url="{{ url('firm/employees/devices') }}" + "/"+id;

                $.ajax({
                    url: url,
                    method:"get",
                    success: function (data) {
                        $('#devicesModal .data').html(data);
                        $('#devicesModal').modal('show');
                    },
                    error:function (err) {
                        console.log(err);
                    }
                })
            });

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
                    url:'{{("/firm/employees/")}}'+id+'/check-has-relations',
                    data: {
                    },
                    success:function(data){
                        if(data.data===true) {
                            alert('Sorry this employee has relations and con\'t be deleted');
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

@section('models')
    <!-- Employee Assets Modal -->
    <div class="modal fade" id="assetsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="assetsModalLabel">Employee Assets</h4>
                </div>
                <div class="data">

                </div>
            </div>
        </div>
    </div>

    <!-- Employee Devices Modal -->
    <div class="modal fade" id="devicesModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="devicesModalLabel">Employee Devices</h4>
                </div>
                <div class="data">

                </div>
            </div>
        </div>
    </div>
@endsection
