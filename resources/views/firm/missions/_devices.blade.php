<form action="{{url('firm/missions/devices/'.$_mission->id)}}" method="post">
    <div class="modal-body">
        @if($devices)
            <select name="mission_devices[]" multiple="multiple" class="js-example-basic-multiple form-control show-tick ">
                @foreach($devices as $device)
                    <option value="{{$device->id}}"
                            @foreach($_mission->devices as $mission_device)
                                @if($mission_device->id == $device->id) selected @endif
                            @endforeach
                    >{{$device->display_name}}</option>
                @endforeach
            </select>
            <input type="hidden" name="mission" value="{{ $_mission }}">
        @else
            <p>No devices yet!</p>
        @endif
        <div>
            <hr>
            <h5>Employee Devices</h5>
            @if(count(\App\Employee::find($_mission->EmpId)->devices) > 0)
                @foreach(\App\Employee::find($_mission->EmpId)->devices as $device)
                    <span class="badge badge-pill badge-success ">{{$device->display_name}}</span>
                @endforeach
            @else
                <p>This employee has no devices</p>
            @endif
        </div>
    </div>
    <div class="modal-footer">
        @csrf
        <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('.js-example-basic-multiple').off().select2();
        $('.select2-container--default').css('width', '100%');
        $('.select2-selection__choice').css({'margin-bottom': '5px'});
    });
</script>