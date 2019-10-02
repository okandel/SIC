@extends('firm.layout.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>Send location using socket</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <label for="lat">Lat</label>
                    <input style="background-color: lightgrey" class="form-control" type="number" step="0.1" id="lat" name="lat" required>
                </div>
                <div class="col-sm-6">
                    <label for="lng">Lng</label>
                    <input style="background-color: lightgrey" class="form-control" type="number" step="0.1" id="lng" name="lng" required>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="alt">Alt</label>
                    <input style="background-color: lightgrey" class="form-control" type="number" step="0.1" id="alt" name="alt">
                </div>
                <div class="col-sm-4">
                    <label for="speed">Speed</label>
                    <input style="background-color: lightgrey" class="form-control" type="number" step="0.1" id="speed" name="speed">
                </div>
                <div class="col-sm-4">
                    <label for="bearing_heading">Bearing/heading</label>
                    <input style="background-color: lightgrey" class="form-control" type="number" step="0.1" id="bearing_heading" name="bearing_heading">
                </div>
            </div>
            <input id="save_btn" type="button" class="btn btn-primary" value="Save">
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
    <script>
        $(document).ready(function(){
            var user_id = '{{session()->get('user_firm')->id}}';
            var username = '{{session()->get('user_firm')->first_name}}';

            var socket = io.connect('http://localhost:5000/location',
                { query:{ user_id: user_id, username: username }});

            $('#save_btn').on('click', function () {
                socket.emit('send_location', {
                    user_id: user_id,
                    lat: $('#lat').val(),
                    lng: $('#lng').val(),
                    alt: $('#alt').val(),
                    speed: $('#speed').val(),
                    bearing_heading	: $('#bearing_heading').val(),
                });

                $('#lat').val("");
                $('#lng').val("");
                $('#alt').val("");
                $('#speed').val("");
                $('#bearing_heading').val("");
            });

            socket.on('send_location', function (data) {
                socket.emit('response_location', {
                    user_id: user_id,
                    lat: $('#lat').val(),
                    lng: $('#lng').val(),
                    alt: $('#alt').val(),
                    speed: $('#speed').val(),
                    bearing_heading	: $('#bearing_heading').val(),
                });
            });

        });
    </script>
@endsection