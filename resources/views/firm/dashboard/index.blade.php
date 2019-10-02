@extends('firm.layout.app')
@section('title') Home @endsection
@section('styles')
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href='{{url("/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")}}' rel="stylesheet" />
    <!-- Wait Me Css -->
{{--    <link href='{{url("/assets/plugins/waitme/waitMe.css")}}' rel="stylesheet" />--}}
    <!-- Bootstrap Select Css -->
{{--    <link href='{{url("/assets/plugins/bootstrap-select/css/bootstrap-select.css")}}' rel="stylesheet" />--}}
    <link href='{{url("/assets/css/select2.min.css")}}' rel="stylesheet" />
<style>
/* 
.search-wrapper-custom{width:485px;position:fixed;right:0px;top:188px;z-index:999;-webkit-transition:transform 400ms ease;transition:transform 400ms ease;-webkit-transform:translateY(130%);transform:translateX(130%)}.search-wrapper-custom.is-open{-webkit-transform:translateY(0);transform:translateY(0)}.search-wrapper-custom .card{margin:0;padding:15px;border-radius:10px;box-shadow:1px 1px 100px 2px rgba(0,0,0,0.22)}.search-wrapper-custom .card .header{border-radius:10px 10px 0 0}

.search-wrapper-custom{right:0px;top:188px;} */

.statistics-wrapper-custom
{
 
 width: 89px;
 /* height: calc(90vh - 180px); */
 position: absolute;
 right: 1px;
 top: 80px;
 /* background: #fdfdfd; */
 z-index: 13 !important;
 -webkit-box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
 -moz-box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
 -ms-box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
 box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
 overflow: hidden;
 -moz-transition: .5s;
 -o-transition: .5s;
 -webkit-transition: .5s;
 transition: .5s; 
 margin-top: 10px;
 margin-right: 10px;
 
}

.search-wrapper-custom{
 
    width: 460px;
    /* height: calc(90vh - 180px); */
    position: absolute;
    right: -500px;
    top: 20px;
    /* background: #fdfdfd; */
    z-index: 13 !important;
    -webkit-box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
    -moz-box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
    -ms-box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
    box-shadow: -2px 2px 5px rgba(0,0,0,0.1);
    overflow: hidden;
    -moz-transition: .5s;
    -o-transition: .5s;
    -webkit-transition: .5s;
    transition: .5s;
    display:none;
    margin-top: 10px;
    margin-right: 10px;
    
}
.map-section
{
    margin-right: 0px;
   
    -moz-transition: .5s;
    -o-transition: .5s;
    -webkit-transition: .5s;
    transition: .5s;
}
.show-map-serach .search-wrapper-custom{

    right: 0px;
    /*display:block;*/
}
.show-map-serach .map-section{

    margin-right:450px; 
}


.search-launcher-custom
{
    position: relative;
    /* right: 9px;
    top: 30px; */
    top: 20px;
    width: 44px;
    height: 37px;
    z-index: 9999;
    color: #fff;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 0 6px rgba(0,0,0,0.16), 0 6px 12px rgba(0,0,0,0.32);
    background: linear-gradient(45deg,#298702 , #68f76c) !important;
    padding-left: 44px;
}
 
.search-launcher-custom:before {
font-family: "Font Awesome 5 Free"; font-weight: 700; content: "\f002";
    font-size: 12px;
    position: absolute;
    right: 17px;
    top: 8px;
    -webkit-transition: transform 180ms linear, opacity 130ms linear;
    transition: transform 180ms linear, opacity 130ms linear;
}
/* .search-launcher-custom:after { 
    font-size: 17px;
    position: absolute;
    right: 17px;
    top: 8px;
    -webkit-transition: transform 180ms linear, opacity 130ms linear;
    transition: transform 180ms linear, opacity 130ms linear;
} */
.search-launcher-custom.ggg { 
    
    background: linear-gradient(45deg, #e46969, #db0a0a) !important; 
}  
  .search-launcher-custom.ggg:before {
font-family: "Font Awesome 5 Free"; font-weight: 700; content: "\f00d" !important;
    opacity: 1;
    -webkit-transform: rotate(0deg) scale(1);
    transform: rotate(0deg) scale(1);
}  

 .ggg:after {
    font-family: "Font Awesome 5 Free"; font-weight: 700; content: "\f136"; 
    opacity: 0;
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
}  
</style>
@endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-home fa-1x"></i> Home - Today Missions</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('home') }}</p>
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
                <!-- <div class="header"> 
                   
                  
                </div> -->
                <div class="body">
                
                <div class="float-right search-launcher-custom" style="">  
                  
                    </div>
                    <section class="map-section" style=""> 
                                    <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                     
                                    <div class="body">
                                    <div class="body row" style="margin-top: -15px; margin-bottom: -15px">

                                    </div>
                                        <div id="gmap_markers" class="gmap"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <aside  class="statistics-wrapper-custom" style="">
                        <div class="row clearfix">
                                        <div class="col-sm-12">
                                            <div class="card">
                                                    <div class="row">
                                                        <div class="  text-center">
                                                            <div class="body">
                                                                <p>All Missions</p>
                                                                <h2 id="stat_all" class="text-center badge badge-pill badge-default" style="font-size: 20px"> 1</h2>
                                                            </div>
                                                        </div>  
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-auto text-center">
                                                            <div class="body">
                                                                <p>Scheduled</p>
                                                                <h2 id="stat_scheduled"  class="text-center badge badge-pill badge-success" style="font-size: 20px"> 2</h2>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="row">
                                                        <div class="  text-center">
                                                            <div class="body">
                                                                <p>Done</p>
                                                                <h2  id="stat_done" class="text-center badge badge-pill badge-primary" style="font-size: 20px"> 1</h2>
                                                            </div>
                                                        </div>  
                                                    </div> 
                                                    <div class="row"> 
                                                        <div class="col-auto text-center">
                                                            <div class="body">
                                                                <p>Rearranged</p>
                                                                <h2  id="stat_rearranged" class="text-center badge badge-pill badge-info" style="font-size: 20px"> 2</h2>
                                                            </div>
                                                        </div> 
                                                    </div>  
                                            </div>
                                        </div>
                                    </div>
                        </aside>
                        
                        <aside  class="search-wrapper-custom" style="">
                      
                            <div class="card">
                                <div class="header">
                                    <h2>Search</h2>
                                </div>
                                <div class="body">
                                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 500px;">
                                        <div class="chat-widget" style="overflow: hidden; width: auto; height: 500px;">


                                        <div class="row">

                                        <div class="col-md-12">

                                                <form method="get" id="form_missions_search">
                                                        <div class="row clearfix">

                                                            <div class="col-md-6">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line" style="margin-top: -28px">
                                                                        <label for="EmpId" style="margin-top: 0; margin-bottom: 0">Employee</label>
                                                                        <select style="width: 100%" name="EmpId" id="EmpId" multiple="multiple" class="form-control show-tick" tabindex="-98">

                                                                                @if($employees)
                                                                                    @foreach($employees as $employee)
                                                                                        <option value="{{ $employee->id }}" >{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line" style="margin-top: -28px">
                                                                        <label for="vehicleId" style="margin-top: 0; margin-bottom: 0">vehicle</label>
                                                                        <select style="width: 100%" name="vehicleId" id="vehicleId" multiple="multiple" class="form-control show-tick" tabindex="-98">

                                                                                @if($vehicles)
                                                                                    @foreach($vehicles as $vehicle)
                                                                                        <option value="{{ $vehicle->id }}" >{{ $vehicle->type }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h5>Nearest Employee To </h5>
                                                        <div class="row clearfix">

                                                            <div class="col-md-6">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line" style="margin-top: -28px">
                                                                        <label for="nearest_EmpId" style="margin-top: 0; margin-bottom: 0">Employee</label>
                                                                        <select style="width: 100%" name="nearest_EmpId" id="nearest_EmpId" multiple="multiple" class="form-control show-tick" tabindex="-98">

                                                                                @if($employees)
                                                                                    @foreach($employees as $employee)
                                                                                        <option value="{{ $employee->id }}" >{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line" style="margin-top: -28px">
                                                                        <label for="nearest_vehicleId" style="margin-top: 0; margin-bottom: 0">vehicle</label>
                                                                        <select style="width: 100%" name="nearest_vehicleId" id="nearest_vehicleId" multiple="multiple" class="form-control show-tick" tabindex="-98">
                                                                                @if($vehicles)
                                                                                    @foreach($vehicles as $vehicle)
                                                                                        <option value="{{ $vehicle->id }}" >{{ $vehicle->type }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line" style="margin-top: -28px">
                                                                        <label for="ClientId" style="margin-top: 0; margin-bottom: 0">Client</label>
                                                                        <select style="width: 100%" name="nearest_ClientId" id="nearest_ClientId" class="form-control show-tick" tabindex="-98">
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
                                                            <!-- <div class="col-md-6">
                                                                <div class="form-group form-float">
                                                                    <div class="form-line" style="margin-top: -28px">
                                                                        <label for="ClientBranchId" style="margin-top: 0; margin-bottom: 0">Branch (Select client first)</label>
                                                                        <select style="width: 100%" name="ClientBranchId" id="ClientBranchId" class="form-control show-tick" tabindex="-98">
                                                                                <option value="">-- Select branch --</option>
                                                                                @if($branches)
                                                                                    @foreach($branches as $branch)
                                                                                        <option value="{{ $branch->id }}" >{{ $branch->display_name }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                    </div>
                                                                </div>
                                                            </div>    -->
                                                        </div>
                                                        <div class="row clearfix">
                                                            <div class="col-sm-12" style="margin-top: 30px">
                                                                <button type="submit" class="btn btn-sm btn-raised btn-primary m-1-15 waves-effect"><i class="fa fa-filter"></i> Filter</button>
                                                                <button type="button" class="btn btn-sm btn-raised btn-warning m-1-15 waves-effect" id="clear_button"><i class="fa fa-times"></i> Clear</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                    
                    
                        </aside>
                    </section>
                </div>
            </div>
        </div>
        <!-- Google Maps -->

        <!-- #END# Markers -->
    </div>
@endsection

@section('models')
    <!-- Mission Assets Modal -->
    <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Mission Details</h4>
                </div>
                <div class="data">

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
    <script src='{{url("/assets/js/select2.min.js")}}'></script>


    <script src="https://maps.google.com/maps/api/js?v=3&sensor=false"></script> <!-- Google Maps API Js -->
    <script src='{{ url("/assets/plugins/gmaps/gmaps.js") }}'></script> <!-- GMaps PLugin Js -->


    <script>

    $(document).ready(function () {
        $(".search-launcher-custom").on("click", function() {
            debugger;
            // $(".search-launcher-custom").toggleClass("active"), $(".search-wrapper-custom").toggleClass("is-open")
            // $(".search-wrapper-custom").toggle()
            $(".search-wrapper-custom").toggle('ease');
$("body").toggleClass("show-map-serach");
$(".search-launcher-custom").toggleClass("ggg");
           
        })
    });
        </script>
<script>
    $(document).ready(function () {
        _employee = $('#EmpId');
        _vehicle = $('#vehicleId');

        _nearest_employee = $('#nearest_EmpId');
        _nearest_vehicle = $('#nearest_vehicleId');
        _nearest_client = $('#nearest_ClientId');

        _client = $('#ClientId');
        _branch = $('#ClientBranchId');

        // $('select').select2();
        _employee.select2({
            placeholder: "Select an employee",
            allowClear: true,
			tags: true
        });
        _vehicle.select2({
            placeholder: "Select a vehicle",
            allowClear: true,
			tags: true
        });


        _nearest_employee.select2({
            placeholder: "Select an employee",
            allowClear: true,
			tags: true
        });
        _nearest_vehicle.select2({
            placeholder: "Select a vehicle",
            allowClear: true,
			tags: true
        });
        _nearest_client.select2({
            placeholder: "Select an client",
            allowClear: true,
			tags: true
        });


        _client.select2({
            placeholder: "Select a client"
        });
        _branch.select2({
            placeholder: "Select a branch"
        });
        $('.dropdown-toggle').attr('hidden', 'true');



        // Draw table after Clear
        $('#clear_button').on('click', function(e) {

            _vehicle.val(null).trigger('change');
            _employee.val(null).trigger('change');
            _client.val(null).trigger('change');
            _branch.val(null).trigger('change');

            _nearest_employee.val(null).trigger('change');
            _nearest_vehicle.val(null).trigger('change');
            _nearest_client.val(null).trigger('change');

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

        function check_inputs(){
            if (_employee.children("option:selected").val() !== '' ||
                _client.children("option:selected").val() !== '' ||
                _branch.children("option:selected").val() !== ''
            ){
                $('#clear_button').attr('hidden', false)
            } else {
                $('#clear_button').attr('hidden', true)
            }
        }
        check_inputs();

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
</script>
<script>
    var $markerList = [];
    var $markerData = [];
    var map = null;

    function initMap() {
        var uluru = {lat: 30.0594699, lng: 31.188424};
        var map = new google.maps.Map(document.getElementById('gmap_markers'), {
          zoom: 15,
          center: uluru
        });
        return map;
    }
    
    function bindStatistics(data) { 
        $("#stat_all").html(0);
        $("#stat_scheduled").html(0);
        $("#stat_done").html(0);
        $("#stat_rearranged").html(0); 
        if (data!=null)
        {
            $("#stat_all").html(data.total_tasks);
            $("#stat_scheduled").html(data.new_tasks);
            $("#stat_done").html(data.done_tasks);
            $("#stat_rearranged").html(data.Rearranged_tasks); 
        } 
    }
    function bindMarkers(data) {
        console.log(data);
        $.each($markerList, function( index, value ) {
            value.setMap(null);
        });
        $markerList = [];

        var latlngbounds = new google.maps.LatLngBounds();
        $.each(data, function( index, value ) {
            var lat= value.client_branch.lat;
            var lng= value.client_branch.lng;

            var uluru = {lat: lat, lng: lng};
            map.setCenter({lat: lat, lng: lng});

            var marker = new google.maps.Marker({
                position: uluru,
                map: map,
                title: value.title,
                additionalData:value
            });
            marker.addListener('click', function() {
                showMarkerPopup(marker);
            });
            $markerList.push(marker);
            latlngbounds.extend(new google.maps.LatLng(lat, lng));
        });

        if (data.length>0)
        {
            map.fitBounds(latlngbounds);
        }

    }

    function loadTodayMissions() {
        var _employee = $('#EmpId').val();
        var _client = $('#ClientId').val();
        var _branch = $('#ClientBranchId').val();
        var _nearest_employees = $('#nearest_EmpId').val();
        var _nearest_vehicles = $('#nearest_vehicleId').val();
        var _nearestClientIds = $('#nearest_ClientId').val();

        $markerData = [];
        var url="{{ url('api/employee/missions/list-today') }}";
        $.ajax({
            url: url,
            method: 'POST',
            dataType: "JSON",
            contentType:"application/x-www-form-urlencoded; charset=UTF-8",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:  {
                EmpId: _employee,
                ClientBranchId: _client,
                ClientId: _branch,
                nearestEmployees: _nearest_employees,
                nearestClientIds: _nearestClientIds,
                nearestVehicleIds: _nearest_vehicles,
                include_statistics:1
            },
            success: function (response) {
                debugger;
                $.each(response.data.missions, function( index, value ) {
                    $markerData.push(value);
                });
                bindMarkers($markerData);
                bindStatistics(response.data.statistics);
                $(".ggg").click();

            },
            error:function (err) {
                console.log(err);
            }
        })
    }

    function showMarkerPopup(marker)
    {
        additionalData = marker.additionalData;
        var url="{{ url('firm/missions/pop-up') }}" + "/"+additionalData.id;
                $.ajax({
                    url: url,
                    method:"get",
                    success: function (data) {
                        $('#defaultModal .data').html(data);
                        $('#defaultModal').modal('show');

                        // var infowindow = new google.maps.InfoWindow({
                        //     content: data
                        // });
                        // infowindow.open(map, marker);
                    },
                    error:function (err) {
                        console.log(err);
                    }
                })
    }

$(function () {

    //bind to empty 
    bindStatistics();
    map = initMap();
    loadTodayMissions();

    $('#form_missions_search').on('submit', function(e) {
            map = initMap();
            loadTodayMissions();
                e.preventDefault();
        });
    // //Markers
    // var markers = new GMaps({
    //     div: '#gmap_markers',
    //     lat: 30.0594699,
    //     lng: 31.188424
    // });
    // markers.addMarker({
    //     lat: 30.0594699,
    //     lng: 31.188424,
    //     title: 'Lima',
    //     details: {
    //         database_id: 42,
    //         author: 'HPNeo'
    //     },
    //     // mouseover: function (e) {
    //     //     if (console.log)
    //     //         console.log(e);
    //     //     alert('You clicked in this marker');
    //     // },
    //     click: function (e) {
    //         if (console.log)
    //             console.log(e);

    //             var infowindow = new google.maps.InfoWindow({
    //       content: contentString
    //     });

    //         var url="{{ url('firm/missions/vehicles') }}" + "/"+1;

    //         $.ajax({
    //             url: url,
    //             method:"get",
    //             success: function (data) {
    //                 $('#defaultModal .data').html(data);
    //                 $('#defaultModal').modal('show');
    //             },
    //             error:function (err) {
    //                 console.log(err);
    //             }
    //         })
    //     }
    // });

});
</script>
@endsection
