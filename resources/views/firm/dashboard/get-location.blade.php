@extends('firm.layout.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3>Get locations using socket</h3>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Lat</th>
                        <th scope="col">Lng</th>
                        <th scope="col">Alt</th>
                        <th scope="col">Speed</th>
                        <th scope="col">Bearing/heading</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>

    <script>
        $(document).ready(function(){
            var user_id = '{{session()->get('user_firm')->id}}';
            var username = '{{session()->get('user_firm')->first_name}}';

            var socket = io('http://localhost:5000/location',
                { query: { user_id: user_id, username: username }});

            socket.on('get_location', function (data) {
                $('#tbody').append(
                    '<tr>' +
                        '<th>'+data.user_id+'</th>\n' +
                        '<td>'+data.lat+'</td>\n' +
                        '<td>'+data.lng+'</td>\n' +
                        '<td>'+data.alt+'</td>\n' +
                        '<td>'+data.speed+'</td>\n' +
                        '<td>'+data.bearing_heading+'</td>\n' +
                    '</tr>'
                );
            });

        });
    </script>
@endsection