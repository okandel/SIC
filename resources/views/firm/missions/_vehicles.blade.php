<form action="{{url('firm/missions/vehicles/'.$_mission->id)}}" method="post">
    <div class="modal-body">
        @if($vehicles)
            <select name="mission_vehicles[]" multiple="multiple" class="js-example-basic-multiple form-control show-tick ">
                @foreach($vehicles as $vehicle)
                    <option value="{{$vehicle->id}}"
                            @foreach($_mission->vehicles as $mission_vehicle)
                                @if($mission_vehicle->id == $vehicle->id) selected @endif
                            @endforeach
                    >{{$vehicle->type}}</option>
                @endforeach
            </select>
            <input type="hidden" name="mission" value="{{ $_mission }}">
        @else
            <p>No vehicles yet!</p>
        @endif
        <div>
            <hr>
            <h5>Employee Assets</h5>
            @if(count(\App\Employee::find($_mission->EmpId)->vehicles) > 0)
                @foreach(\App\Employee::find($_mission->EmpId)->vehicles as $vehicle)
                    <span class="badge badge-pill badge-success ">{{$vehicle->type}}</span>
                @endforeach
            @else
                <p>This employee has no assets</p>
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