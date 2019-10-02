@extends('firm.layout.app')

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
.search-wrapper-custom{

    background-color: red;
    width: 460px;
    height: calc(100vh - 0px);
    position: absolute;
    right: -500px;
    top: 0px;
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

/******************************************************************************************/
/* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
#map {
    height: 100%;
}
/* Optional: Makes the sample page fill the window. */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}
#description {
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
}

#infowindow-content .title {
    font-weight: bold;
}

#infowindow-content {
    display: none;
}

#map #infowindow-content {
    display: inline;
}

.pac-card {
    margin: 10px 10px 0 0;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    background-color: #fff;
    font-family: Roboto;
}

#pac-container {
    padding-bottom: 12px;
    margin-right: 12px;
}

.pac-controls {
    display: inline-block;
    padding: 5px 11px;
}

.pac-controls label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
}

#pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
    width: 400px;
}

#pac-input:focus {
    border-color: #4d90fe;
}

#title {
    color: #fff;
    background-color: #4d90fe;
    font-size: 25px;
    font-weight: 500;
    padding: 6px 12px;
}
</style>
@endsection

@section('breadcrumbs')
    <div class="ml-3" style="margin-bottom: -15px">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <h2 class="mb-0"><i class="fa fa-home fa-1x"></i> Home - Today Missions</h2>
                <p>{{ Breadcrumbs::render('home') }}</p>
            </li>
        </ul>
    </div>
@endsection

@section('content')
<div class="container-fluid">

{{-------------------------------------------------------------------------------------------------}}
    <div class="pac-card" id="pac-card">
        <div>
            <div id="title">
                Autocomplete search
            </div>
            <div id="type-selector" class="pac-controls">
                <input type="radio" name="type" id="changetype-all" checked="checked">
                <label for="changetype-all">All</label>

                <input type="radio" name="type" id="changetype-establishment">
                <label for="changetype-establishment">Establishments</label>

                <input type="radio" name="type" id="changetype-address">
                <label for="changetype-address">Addresses</label>

                <input type="radio" name="type" id="changetype-geocode">
                <label for="changetype-geocode">Geocodes</label>
            </div>
            <div id="strict-bounds-selector" class="pac-controls">
                <input type="checkbox" id="use-strict-bounds" value="">
                <label for="use-strict-bounds">Strict Bounds</label>
            </div>
        </div>
        <div id="pac-container">
            <input id="pac-input" type="text"
                   placeholder="Enter a location">
        </div>
    </div>
    <div id="map"></div>
    <div id="infowindow-content">
        <img src="" width="16" height="16" id="place-icon">
        <span id="place-name"  class="title"></span><br>
        <span id="place-address"></span>
    </div>

    <script>
        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -33.8688, lng: 151.2195},
                zoom: 13
            });
            var card = document.getElementById('pac-card');
            var input = document.getElementById('pac-input');
            var types = document.getElementById('type-selector');
            var strictBounds = document.getElementById('strict-bounds-selector');

            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

            var autocomplete = new google.maps.places.Autocomplete(input);

            // Bind the map's bounds (viewport) property to the autocomplete object,
            // so that the autocomplete requests use the current map bounds for the
            // bounds option in the request.
            autocomplete.bindTo('bounds', map);

            // Set the data fields to return when the user selects a place.
            autocomplete.setFields(
                ['address_components', 'geometry', 'icon', 'name']);

            var infowindow = new google.maps.InfoWindow();
            var infowindowContent = document.getElementById('infowindow-content');
            infowindow.setContent(infowindowContent);
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);  // Why 17? Because it looks good.
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindowContent.children['place-icon'].src = place.icon;
                infowindowContent.children['place-name'].textContent = place.name;
                infowindowContent.children['place-address'].textContent = address;
                infowindow.open(map, marker);
            });

            // Sets a listener on a radio button to change the filter type on Places
            // Autocomplete.
            function setupClickListener(id, types) {
                var radioButton = document.getElementById(id);
                radioButton.addEventListener('click', function() {
                    autocomplete.setTypes(types);
                });
            }

            setupClickListener('changetype-all', []);
            setupClickListener('changetype-address', ['address']);
            setupClickListener('changetype-establishment', ['establishment']);
            setupClickListener('changetype-geocode', ['geocode']);

            document.getElementById('use-strict-bounds')
                .addEventListener('click', function() {
                    console.log('Checkbox clicked! New state=' + this.checked);
                    autocomplete.setOptions({strictBounds: this.checked});
                });
        }
    </script>
{{-------------------------------------------------------------------------------------------------}}

    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <!-- <div class="header">


                </div> -->
                <div class="body">

                <div class="float-right" style="position: relative;
    right: 9px;
    top: -4px;
    width: 50px;
    height: 50px;
    z-index: 9999;
    color: #fff;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 0 6px rgba(0,0,0,0.16), 0 6px 12px rgba(0,0,0,0.32);
    background: linear-gradient(45deg, #fda582, #f7cf68) !important;
     ">
                        <a href="javascript:void(0);" class="search-launcher-custom" data-close="true"><i class="zmdi zmdi-search"></i></a>

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

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
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
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
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

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
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
                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
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

                                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
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
                                                            <!-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
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
                                    <div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.4); width: 2px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 3px; z-index: 99; right: 1px; height: 149.007px;"></div><div class="slimScrollRail" style="width: 2px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 2px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>

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
        <div class="modal-dialog" role="document">
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
            },
            success: function (response) {
                debugger;
                $.each(response.data.missions, function( index, value ) {
                    $markerData.push(value);
                });
                bindMarkers($markerData);

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
