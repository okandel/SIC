@extends('firm.layout.app')

@section('title') Missions @endsection

@section('styles')
    <link rel="stylesheet" href='{{ url("/assets/css/datatables.min.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/dataTables.bootstrap.min.css") }}'>
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href='{{url("/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")}}' rel="stylesheet" />
    <link href='{{url("/assets/css/select2.min.css")}}' rel="stylesheet" />
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-project-diagram fa-1x"></i> Missions</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('missions') }}</p>
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
                        <div class="col-sm-9" >
                            <form method="get" id="form_missions_search">
                                <div class="row clearfix">
                                    <div class="row">
                                        {{--Employee search field--}}
                                        <div style="margin-left: 30px; margin-top: -25px; width: 17%">
                                            <div class="form-group form-float">
                                                <label for="EmpId" style="margin-top: 0; margin-bottom: 0">Employee</label>
                                                <div style="margin-top: 0" class="btn-group bootstrap-select form-control show-tick focused">
                                                    <select style="width: 100%" name="EmpId" id="EmpId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                                                        <option value="">-- Select employee --</option>
                                                        @if($employees)
                                                            @foreach($employees as $employee)
                                                                <option value="{{ $employee->id }}" >{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        {{--Client search field--}}
                                        <div style="margin-left: 10px; margin-top: -25px; width: 17%">
                                            <div class="form-group form-float">
                                                <label for="ClientId" style="margin-top: 0; margin-bottom: 0">Client</label>
                                                <div style="margin-top: 0" class="btn-group bootstrap-select form-control show-tick focused">
                                                    <select style="width: 100%" name="ClientId" id="ClientId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                                                        <option value="">-- Select client --</option>
                                                        @if($clients)
                                                            @foreach($clients as $client)
                                                                <option value="{{ $client->id }}" >{{ $client->contact_person }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        {{--Client branch search field--}}
                                        <div style="margin-left: 10px; margin-top: -25px; width: 17%">
                                            <div class="form-group form-float">
                                                <label for="ClientBranchId" style="margin-top: 0; margin-bottom: 0">Branch (select client)</label>
                                                <div style="margin-top: 0" class="btn-group bootstrap-select form-control show-tick focused">
                                                    <select style="width: 100%" name="ClientBranchId" id="ClientBranchId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                                                        <option value="">-- Select branch --</option>
                                                        @if($branches)
                                                            @foreach($branches as $branch)
                                                                <option value="{{ $branch->id }}" >{{ $branch->display_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        {{--Item search field--}}
                                        <div style="margin-left: 10px; margin-top: -25px; width: 17%">
                                            <div class="form-group form-float">
                                                <label for="ItemId" style="margin-top: 0; margin-bottom: 0">Item</label>
                                                <div style="margin-top: 0" class="btn-group bootstrap-select form-control show-tick focused">
                                                    <select style="width: 100%" name="ItemId" id="ItemId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                                                        <option value="">-- Select item --</option>
                                                        @if($items)
                                                            @foreach($items as $item)
                                                                <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        {{--Status search field--}}
                                        <div style="margin-left: 10px; margin-top: -25px; width: 17%">
                                            <div class="form-group form-float">
                                                <label for="StatusId" style="margin-top: 0; margin-bottom: 0">Status</label>
                                                <div style="margin-top: 0" class="btn-group bootstrap-select form-control show-tick focused">
                                                    <select style="width: 100%" name="StatusId" id="StatusId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                                                        <option value="">-- Select status --</option>
                                                        @if($statuses)
                                                            @foreach($statuses as $status)
                                                                <option value="{{ $status->id }}" >{{ $status->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        {{--From date search field--}}
                                        <div style="margin-left: 35px; margin-top: -25px; width: 17%">
                                            <label class="mb-0" for="from_date">From Date</label>
                                            <div class="form-group mt-0">
                                                <div class="form-line">
                                                    <input type="text" id="from_date" name="from_date" class="datepicker form-control" placeholder="Enter start date">
                                                </div>
                                            </div>
                                        </div>
                                        {{--To date search field--}}
                                        <div style="margin-left: 10px; margin-top: -25px; width: 17%">
                                            <label class="mb-0" for="to_date">To Date</label>
                                            <div class="form-group mt-0">
                                                <div class="form-line">
                                                    <input type="text" id="to_date" name="to_date" class="datepicker form-control" placeholder="Enter start date">
                                                </div>
                                            </div>
                                        </div>
                                        {{--Filter & Clear buttons--}}
                                        <div style="margin-left: 20px; margin-top: 7px; width: 30%">
                                            <button type="submit" class="btn btn-sm btn-raised btn-primary waves-effect"><i class="fa fa-filter"></i> Filter</button>
                                            <button type="button" class="btn btn-sm btn-raised btn-warning waves-effect" id="clear_button"><i class="fa fa-times"></i> Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2 m-auto">
                            <a style="float: right; margin-top: 5px; margin-bottom: 20px" class="btn btn-success" href="{{ url('firm/missions/create') }}"><i class="fa fa-plus"></i> Add Mission</a>
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
                            <table  id="missionsData" class="text-center table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Employee</th>
                                    <th class="text-center">Assigned By</th>
                                    <th class="text-center">Priority</th>
                                    <th class="text-center">Client</th>
                                    <th class="text-center">Start Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Tasks</th>
                                    <th class="text-center">Exceptions</th>
                                    <th class="text-center">Assets</th>
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

    <script src='{{ url("/assets/plugins/autosize/autosize.js")}}'></script> <!-- Autosize Plugin Js -->
    <script src='{{ url("/assets/plugins/momentjs/moment.js")}}'></script> <!-- Moment Plugin Js -->
    <script src='{{ url("/assets/js/datatables.min.js") }}'></script>
    <script src='{{ url("/assets/js/dataTables.bootstrap.min.js") }}'></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src='{{url("/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js")}}'></script>
    <script src='{{url("/assets/js/pages/forms/basic-form-elements.js")}}'></script>

    <script src='{{ url("/assets/plugins/sweetalert/sweetalert.min.js")}}'></script>
    <script src='{{ url("/assets/plugins/sweetalert/jquery.sweet-alert.custom.js")}}'></script>
    <script src='{{url("/assets/js/select2.min.js")}}'></script>

    <script>
        $(document).ready(function () {
            _employee = $('#EmpId');
            _client = $('#ClientId');
            _branch = $('#ClientBranchId');
            _item = $('#ItemId');
            _status = $('#StatusId');
            _from = $('#from_date');
            _to = $('#to_date');

            // $('select').select2();
            _employee.select2({
                placeholder: "Select an employee",
                allowClear: true
            });
            _client.select2({
                placeholder: "Select a client",
                allowClear: true
            });
            _branch.select2({
                placeholder: "Select a branch",
                allowClear: true
            });
            _item.select2({
                placeholder: "Select an item",
                allowClear: true
            });
            _status.select2({
                placeholder: "Select a status",
                allowClear: true
            });

            missionsTable = $('#missionsData').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[ 0, "asc" ]],
                // sPaginationType: "full_numbers",
                ajax: {
                    url:"{{ url('/firm/missions/get-missions-data') }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search
                        d.EmpId = _employee.val();
                        d.ClientId = _client.val();
                        d.ClientBranchId = _branch.val();
                        d.ItemId = _item.val();
                        d.StatusId = _status.val();
                        d.from_date = _from.val();
                        d.to_date = _to.val();
                    }
                },
                type: 'GET',
                columns: [
                    {
                        data: 'id', name: 'id',
                        "searchable": true,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(oData.id);
                        }
                    },
                    {
                        data: 'title', name: 'title',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                '<a href="{{url('firm/missions')}}'+'/' + oData.id + '/details' +' ">'+oData.title+'</a>'
                            );
                        }
                    },
                    {
                        data: 'EmpId', name: 'EmpId',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.EmpId){
                                $(nTd).html(
                                    '<a href="{{url('firm/employees')}}'+'/' + oData.employee.id + '/profile' +' ">'+oData.employee.first_name+'</a>'
                                );
                            } else {
                                $(nTd).html(
                                    "-----"
                                );
                            }
                        }
                    },
                    {
                        data: 'AssignedBy', name: 'AssignedBy',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.AssignedBy){
                                $(nTd).html(
                                    '<a href="{{url('firm/users')}}'+'/' + oData.assigned_by.id + '/profile' +' ">'+oData.assigned_by.first_name+'</a>'
                                );
                            } else {
                                $(nTd).html(
                                    "-----"
                                );
                            }
                        }
                    },
                    {
                        data: 'PriorityId', name: 'PriorityId',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.PriorityId){
                                $(nTd).html(oData.priority.name);
                            } else {
                                $(nTd).html(
                                    "-----"
                                );
                            }
                        }
                    },
                    {
                        data: 'ClientBranchId', name: 'ClientBranchId',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.ClientBranchId){
                                $(nTd).html(
                                    '<a href="{{url('firm/clients')}}'+'/' + oData.client_branch.id + '/profile' +' ">'+oData.client_branch.client.contact_person+'</a>'
                                );
                            } else {
                                $(nTd).html(
                                    "-----"
                                );
                            }
                        }
                    },
                    {
                        data: 'start_date', name: 'start_date',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.start_date){
                                $(nTd).html(oData.start_date);
                            } else {
                                $(nTd).html(
                                    "-----"
                                );
                            }
                        }
                    },
                    {
                        data: 'StatusId', name: 'StatusId',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.status.id == 1){ //New
                                $(nTd).html(
                                    "<p class='badge badge-bill badge-success'>"+oData.status.name+"</p>  "
                                );
                            } else if (oData.status.id == 2) { //Pending
                                $(nTd).html(
                                    "<p class='badge badge-bill badge-warning'>"+oData.status.name+"</p>  "
                                );
                            } else if (oData.status.id == 3) { //Completed
                                $(nTd).html(
                                    "<a href='{{url('firm/missions/')}}/" + oData.id + "/status' class='badge badge-bill badge-primary'>"+oData.status.name+"</a>  "
                                );
                            } else if (oData.status.id == 4) { //Expired
                                $(nTd).html(
                                    "<p class='badge badge-bill badge-danger'>"+oData.status.name+"</p>"
                                );
                            } else if (oData.status.id == 5) { //Re-arranged
                                $(nTd).html(
                                    "<a href='{{url('firm/missions/')}}/" + oData.id + "/status' class='badge badge-bill badge-info'>"+oData.status.name+"</a>  "
                                );
                            } else {
                                $(nTd).html(
                                   "-----"
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
                                "<a href='{{url('firm/mission')}}/" +oData.id+'/tasks'+"' title='Tasks' class='btn btn-xs btn-success'><i class='fa fa-tasks'></i></a>"
                            );
                        }
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                "<a href='{{url('firm/mission-recurring-exceptions/index')}}/" +oData.id+"' title='Recurring Exceptions' class='btn btn-xs btn-warning'><i class='fa fa-exclamation-triangle'></i></a>"
                            );
                        }
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                '<button type="button" data-id="'+oData.id+'" class="btn btn-info btn-xs waves-effect assets_btn mb-1" title="Assets"><i class="fa fa-car"></i></button>'+
                                '<button type="button" data-id="'+oData.id+'" class="btn btn-info btn-xs waves-effect devices_btn" title="Devices"><i class="fa fa-mobile-alt"></i></button>'
                            );
                        }
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.recurring_type != null) {
                                $(nTd).html(
                                    "<a href='{{url('firm/missions/')}}/" + oData.id + "/edit' title='Edit' class='btn btn-xs btn-primary mb-1'><i class='fa fa-edit'></i> </a>  "+
                                    "<a href='javascript:' url='{{url('firm/missions/delete/')}}/" + oData.id + "' onclick='checkHasRelations(" + oData.id + ")' title='Delete' id='delete_" + oData.id + "' class='btn btn-xs btn-danger mb-1'><i class='fa fa-trash-alt'></i> </a>" +
                                    "<a href='{{url('firm/missions/')}}/" + oData.id + "/occurrences' title='Occurrences' class='btn btn-xs btn-info mb-1'><i class='fa fa-history'></i> </a>  "
                                );
                            }

                        }
                    }
                ]
            });

            // Draw table after Filter
            $('#form_missions_search').on('submit', function(e) {
                missionsTable.draw();
                e.preventDefault();
            });

            // Draw table after Clear
            $('#clear_button').on('click', function(e) {
                _employee.prop('selectedIndex',0);
                _client.prop('selectedIndex',0);
                _branch.prop('selectedIndex',0);
                _item.prop('selectedIndex',0);
                _status.prop('selectedIndex',0);
                _from.val("");
                _to.val("");
                _employee.select2({
                    placeholder: "Select an employee",
                    allowClear: true
                });
                _client.select2({
                    placeholder: "Select a client",
                    allowClear: true
                });
                _branch.select2({
                    placeholder: "Select a branch",
                    allowClear: true
                });
                _item.select2({
                    placeholder: "Select an item",
                    allowClear: true
                });
                _status.select2({
                    placeholder: "Select a status",
                    allowClear: true
                });
                $('#form_missions_search').submit();
                _branch.attr('disabled', 'true');
                check_inputs();
            });

            _employee.on("change", function () {
                check_inputs();
            });
            _client.on("change", function () {
                check_inputs();
            });
            _branch.on("change", function () {
                check_inputs();
            });
            _item.on("change", function () {
                check_inputs();
            });
            _status.on("change", function () {
                check_inputs();
            });
            _from.on("change", function () {
                check_inputs();
            });
            _to.on("change", function () {
                check_inputs();
            });

            function check_inputs(){
                if (_employee.children("option:selected").val() !== '' ||
                    _client.children("option:selected").val() !== '' ||
                    _branch.children("option:selected").val() !== '' ||
                    _item.children("option:selected").val() !== '' ||
                    _status.children("option:selected").val() !== '' ||
                    _from.val() !== "" ||
                    _to.val() !== ""
                ){
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
                var url="{{ url('firm/missions/vehicles') }}" + "/"+id;

                $.ajax({
                    url: url,
                    method:"get",
                    success: function (data) {
                        $('#defaultModal .data').html(data);
                        $('#defaultModal').modal('show');
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
                var id = $(ctrl).attr("data-id");
                var url = "{{ url('firm/missions/devices') }}" + "/" + id;

                $.ajax({
                    url: url,
                    method: "get",
                    success: function (data) {
                        $('#missionDeviceModal .data').html(data);
                        $('#missionDeviceModal').modal('show');
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            });


            //Get branches after select Client
            _client.on('change', function () {
                if (_client.children("option:selected").val() !== '')
                {
                    check_selected();
                }
            });

            _branch.attr('disabled', 'true');

            function check_selected() {
                var ctrl = _client;
                var id=$(ctrl).val();
                var url="{{ url('firm/missions/client-branches') }}" + "/"+id + "/";
                $.ajax({
                    url: url,
                    method:"get",
                    success: function (data) {
                        @if(count($branches) > 0)
                        _branch.removeAttr('disabled').html(data);
                        @else
                        _branch.attr('disabled', 'true').html(data);
                        @endif
                    },
                    error:function (err) {
                        console.log(err);
                    }
                })
            }

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
                    url:'{{("/firm/missions/")}}'+id+'/check-has-relations',
                    data: {
                    },
                    success:function(data){
                        if(data.data===true) {
                            alert('Sorry this mission has relations and con\'t be deleted');
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
    <!-- Mission Assets Modal -->
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Mission Assets</h4>
                </div>
                <div class="data">

                </div>
            </div>
        </div>
    </div>
    <!-- Mission Devices Modal -->
    <div class="modal fade" id="missionDeviceModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="missionDeviceModalLabel">Mission Devices</h4>
                </div>
                <div class="data">

                </div>
            </div>
        </div>
    </div>
@endsection