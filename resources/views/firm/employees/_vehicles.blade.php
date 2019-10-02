<form action="{{url('firm/employees/vehicles/'.$_employee->id)}}" method="post">
    <div class="modal-body">
        @if($vehicles)
            <select name="employee_vehicles[]" multiple="multiple" class="js-example-basic-multiple form-control show-tick ">
                @foreach($vehicles as $vehicle)
                    <option value="{{$vehicle->id}}"
                            @foreach($_employee->vehicles as $emp_vehicle)
                                @if($emp_vehicle->id == $vehicle->id) selected @endif
                            @endforeach
                    >{{$vehicle->type}}</option>
                @endforeach
            </select>
            <input type="hidden" name="employee" value="{{ $_employee }}">
        @else
            <p>No vehicles yet!</p>
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