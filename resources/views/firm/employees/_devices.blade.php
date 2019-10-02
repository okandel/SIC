<form action="{{url('firm/employees/devices/'.$_employee->id)}}" method="post">
    <div class="modal-body">
        @if($devices)
            <select name="employee_devices[]" multiple="multiple" class="js-example-basic-multiple form-control show-tick ">
                @foreach($devices as $device)
                    <option value="{{$device->device_unique_id}}"
                            @foreach($_employee->devices as $emp_device)
                                @if($emp_device->id == $device->id) selected @endif
                            @endforeach
                    >{{$device->display_name}}</option>
                @endforeach
            </select>
            <input type="hidden" name="employee" value="{{ $_employee }}">
        @else
            <p>No devices yet!</p>
        @endif
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