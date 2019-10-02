<input type="hidden" name="ClientId" value="{{ $ClientId }}">
<input type="hidden" name="lat" value="{{ $branch->lat }}">
<input type="hidden" name="lng" value="{{ $branch->lng }}">

<div class="row">
    <div class="col-sm-6">
        <label for="first_name">Display Name</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $branch->display_name) }}" class="form-control" placeholder="Enter display name">
            </div>
            @if ($errors->has('display_name'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('display_name') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <label for="last_name">Contact Person</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $branch->contact_person) }}" class="form-control" placeholder="Enter contact person">
            </div>
            @if ($errors->has('contact_person'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('contact_person') }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <label for="email_address">Email Address</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="email" name="email" id="email_address" value="{{ old('email', $branch->email) }}" class="form-control" placeholder="Enter email address">
            </div>
            @if ($errors->has('email'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <label for="phone">Phone Number</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="phone" id="phone" value="{{ old('phone', $branch->phone) }}" class="form-control" placeholder="Enter phone number">
            </div>
            @if ($errors->has('phone'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('phone') }}
                </div>
            @endif
        </div>
    </div>
</div>

{{--Reps field--}}
<label for="js-example-basic-multiple">Branch Reps</label>
<div class="row clearfix mt-0 mb-5">
    <div class="col-sm-12">
        <select id="js-example-basic-multiple" name="branch_reps[]" multiple="multiple" class="form-control show-tick mb-5">
            @foreach($reps as $rep)
                <option value="{{$rep->id}}"
                        @foreach($branch->branch_reps as $b_rep)
                        @if($b_rep->id == $rep->id) selected @endif
                        @endforeach
                >{{$rep->first_name}} {{$rep->last_name}}</option>
            @endforeach
        </select>
    </div>
</div>

{{--Address field--}}
<label for="phone">Address</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="address" id="address" value="{{ old('address', $branch->address) }}" class="form-control" placeholder="Enter address">
    </div>
    @if ($errors->has('address'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('address') }}
        </div>
    @endif
</div>


{{--Country field--}}
<div class="row clearfix mt-0 mb-5">
    <div class="col-sm-4">
        <label for="CountryId" style="margin-bottom: 0">Country <span class="text-small">(select country then select State & City)</span></label>
        <select  name="CountryId" id="CountryId"  class="form-control"> 
            <!-- <option value="">-- Please select country --</option> -->
            @if($countries)
                @foreach($countries as $country)
                    <option value="{{$country->id}}"  
                        @if($branch->CountryId == $country->id) selected @endif >{{ $country->name }}</option>
                @endforeach
            @endif
        </select>
        @if ($errors->has('CountryId'))
            <div class="error" style="color: red; ">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('CountryId') }}
            </div>
        @endif
    </div>
    <div class="col-sm-4" >
        <label for="StateId" style="margin-bottom: 0">State</label>

        <select  name="StateId" id="StateId"  class="form-control">
        </select>
        @if ($errors->has('StateId'))
            <div class="error" style="color: red; ">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('StateId') }}
            </div>
        @endif
    </div>
    <div class="col-sm-4" >
        <label for="CityId" style="margin-bottom: 0">City</label>
        <select  name="CityId" id="CityId"  class="form-control"> 
        </select> 
    </div>

</div>
<div class="row">
    <div id="gmap" class="gmap"></div>
</div>
@csrf
<br>
@push('scripts_stack')

    <script src="https://maps.google.com/maps/api/js?v=3&sensor=false"></script> <!-- Google Maps API Js -->
    <script src='{{ url("/assets/plugins/gmaps/gmaps.js") }}'></script> <!-- GMaps PLugin Js -->

<script>
    function showMap(lat,lang,address) {

        var map = new google.maps.Map(document.getElementById('gmap'), {
        zoom: 15,
        //center: myLatLng
        });

        lat = (lat)?lat:30.0331568;
        lang = (lang)?lang:31.4093249;

        if (lat&& lang)
        {   var myLatLng = {lat: lat, lng: lang};

            map.setCenter(myLatLng);
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: address,
                draggable:true,
            });
            marker.setPosition(myLatLng);

            google.maps.event.addListener(marker, 'dragend', function(marker){
                var latLng = marker.latLng;
                currentLatitude = latLng.lat();
                currentLongitude = latLng.lng();
                $("input[name=lat]").val(currentLatitude);
                $("input[name=lng]").val(currentLongitude);
            });
        }

    }

    function loadStates($selected_value=null) {
        var ctrl = $('#CountryId');
            var country_id=parseInt($(ctrl).val());
            if (country_id>0){

                var url="{{ url('api/common/state/list') }}";
                $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: "JSON",
                    contentType:"application/x-www-form-urlencoded; charset=UTF-8",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:  {
                        country_id: country_id
                    },
                    success: function (response) {
                        //$('#StateId').append('<option value=""> -- Please select State --</option>')
                        $.each(response.data, function(key, val) {
                            $('#StateId').append('<option value="'+ val.id+'">'+ val.name+'</option>')
                        });
                        if($selected_value)
                        {
                            $('#StateId').val($selected_value);
                            loadCities('{{ $branch->CityId }}');
                        }else{
                            loadCities();
                        }
                    },
                    error:function (err) {
                        console.log(err);
                    }
                })
            }
        }
        function loadCities($selected_value=null) {
            var ctrl = $('#StateId');
            var state_id=$(ctrl).val();
            var url="{{ url('api/common/city/list') }}";
            $.ajax({
                url: url,
                method: 'POST',
                dataType: "JSON",
                contentType:"application/x-www-form-urlencoded; charset=UTF-8",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:  {
                    state_id: state_id
                },
                success: function (response) {
                    //$('#CityId').append('<option value=""> -- Please select City --</option>')
                    $.each(response.data, function(key, val) {
                        $('#CityId').append('<option value="'+ val.id+'">'+ val.name+'</option>')
                    });
                    if($selected_value)
                    {
                        $('#CityId').val($selected_value);
                    }
                },
                error:function (err) {
                    console.log(err);
                }
            })
        }

        $(document).ready(function () {
            debugger;
            var lat = $("input[name=lat]").val();
            var lng = $("input[name=lng]").val();
            showMap(parseFloat(lat),parseFloat(lng),"client branch");

            @if(!$branch->id)
                $('#CountryId').val("");
            @endif
            loadStates('{{ $branch->StateId }}');
          $('#CountryId,#StateId,#CityId,#js-example-basic-multiple').select2({
            placeholder: "Select",
            allowClear: true
        });
            $('#CountryId').bind('click change', function () {

                if ($('#CountryId').val() !== '')
                {
                    $('#StateId').find('option').remove();
                    loadStates();
                }
            });
            $('#StateId').bind('click change', function () {
                if ($('#StateId').val() !== '')
                {
                    $('#CityId').find('option').remove();
                    loadCities();
                }
            });


        });
    </script>
 @endpush