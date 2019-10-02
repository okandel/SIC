
<div class="row">
    <div class="col-sm-6">
        <label for="first_name">Type</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="type" id="type" value="{{ old('type', $vehicle->type) }}" class="form-control" placeholder="Enter type">
            </div>
            @if ($errors->has('type'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('type') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <label for="last_name">Brand</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="brand" id="brand" value="{{ old('brand', $vehicle->brand) }}" class="form-control" placeholder="Enter brand">
            </div>
            @if ($errors->has('brand'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('brand') }}
                </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <label for="email_address">Year</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="year" id="year" value="{{ old('year', $vehicle->year) }}" class="form-control" placeholder="Enter year">
            </div>
            @if ($errors->has('year'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('year') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <label for="phone">No Of Passengers</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="number" name="no_of_passengers" id="no_of_passengers" value="{{ old('no_of_passengers', $vehicle->no_of_passengers) }}" class="form-control" placeholder="Enter no of passengers">
            </div>
            @if ($errors->has('no_of_passengers'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('no_of_passengers') }}
                </div>
            @endif
        </div>
    </div>
</div>

<label for="phone">Body Type</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="body_type" id="body_type" value="{{ old('body_type', $vehicle->body_type) }}" class="form-control" placeholder="Enter body type">
    </div>
    @if ($errors->has('body_type'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('body_type') }}
        </div>
    @endif
</div>

@csrf
<br>