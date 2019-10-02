<input type="hidden" name="ItemTemplateId" value="{{ $ItemTemplateId }}">

{{--Display name field--}}
<label for="first_name">Display Name</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $field->display_name) }}" class="form-control" placeholder="Enter display name">
    </div>
    @if ($errors->has('display_name'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('display_name') }}
        </div>
    @endif
</div>

{{--Type field--}}
<label for="type">Type</label>
<div class="row clearfix mt-0 mb-5">
    <div class="col-sm-12">
{{--        <div class="btn-group bootstrap-select form-control show-tick focused">--}}
{{--            <div class="dropdown-menu open" role="combobox"><ul class="dropdown-menu inner" role="listbox" aria-expanded="false"><li data-original-index="0" class="selected"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="true"><span class="text">-- Please select --</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="1"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">10</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">20</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="3"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">30</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="4"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">40</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="5"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">50</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div>--}}
            <select name="type" id="type" class="form-control show-tick" tabindex="-98">
                <option value="">-- Please select a type--</option>
                <option value="1" @if($field->type == 1) selected @endif>String</option>
                <option value="2" @if($field->type == 2) selected @endif>Number</option>
                <option value="3" @if($field->type == 3) selected @endif>Decimal</option>
                <option value="4" @if($field->type == 4) selected @endif>Date</option>
                <option value="5" @if($field->type == 5) selected @endif>Multi Select</option>
            </select>
{{--        </div>--}}
    </div>
    @if ($errors->has('type'))
        <div class="error" style="color: red; margin-top: 10px; margin-left: 15px">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('type') }}
        </div>
    @endif
</div>

{{--Options field--}}
<label id="options_label" for="options">Options (Please enter ' , ' after each option)</label>
<div id="options_div" class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="options" data-role="tagsinput" id="tags" value="{{ old('options', $field->options) }}" class="form-control" placeholder="Enter options">
    </div>
</div>

{{--Default value field--}}
<label for="default_value">Default Value</label>
{{--for normal default value--}}
<div class="form-group mt-0" id="normal_default">
    <div class="form-line">
        <input type="text" id="normal_default_input" @if($field->type == "1" || $field->type == "5") name="default_value" value="{{ old('default_value', $field->default_value) }}" @endif class="form-control" placeholder="Enter default value">
    </div>
</div>
{{--for number default value--}}
<div class="form-group mt-0" id="number_default">
    <div class="form-line">
        <input type="number" id="number_default_input" @if($field->type == "2") name="default_value" value="{{ old('default_value', $field->default_value) }}" @endif class="form-control" placeholder="Enter number default value">
    </div>
</div>
{{--for decimal default value--}}
<div class="form-group mt-0" id="decimal_default">
    <div class="form-line">
        <input type="number" step="0.1" id="decimal_default_input" @if($field->type == "3") name="default_value" value="{{ old('default_value', $field->default_value) }}" @endif class="form-control" placeholder="Enter decimal default value">
    </div>
</div>
{{--for date default value--}}
<div class="form-group mt-0" id="date_default">
    <div class="form-line">
        <input type="text" id="date_default_input" @if($field->type == "4") name="default_value" value="{{ old('default_value', $field->default_value) }}" @endif class="datetimepicker form-control" placeholder="Enter default date & time">
    </div>
</div>

{{--Is required field--}}
<label for="is_required">Is Required</label>
<div class="demo-radio-button">
    <input name="is_required" @if($field->is_required == "1") checked @endif id="yes" value="1" type="radio" class="with-gap"/>
    <label for="yes">Yes</label>
    <input name="is_required" @if($field->is_required == "0") checked @endif id="no" value="0" type="radio" class="with-gap"/>
    <label for="no">No</label>
    @if ($errors->has('is_required'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('is_required') }}
        </div>
    @endif
</div>


@csrf
<br>

