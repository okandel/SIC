<label for="first_name">Operating System</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="os_type" id="os_type" value="{{ old('os_type', $device->os_type) }}" class="form-control" placeholder="Enter Operating System">
    </div>
    @if ($errors->has('os_type'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('os_type') }}
        </div>
    @endif
</div>

<label for="last_name">Display name</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $device->display_name) }}" class="form-control" placeholder="Enter display name">
    </div>
    @if ($errors->has('display_name'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('display_name') }}
        </div>
    @endif
</div>

<label for="email_address">Device unique id</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="device_unique_id" id="device_unique_id" value="{{ old('device_unique_id', $device->device_unique_id) }}" class="form-control" placeholder="Enter device unique id">
    </div>
    @if ($errors->has('device_unique_id'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('device_unique_id') }}
        </div>
    @endif
</div>
 

@csrf
<br>