<label for="first_name">Name</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="name" id="name" value="{{ old('name', $type->name) }}" class="form-control" placeholder="Enter name">
    </div>
    @if ($errors->has('name'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('name') }}
        </div>
    @endif
</div>

<label for="last_name">Display Order</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="number" min="0" max="50" name="order" id="order" value="{{ old('order', $type->order) }}" class="form-control" placeholder="Enter order">
    </div>
    @if ($errors->has('order'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('order') }}
        </div>
    @endif
</div>


@csrf
<br>