@if(count($fields) > 0)
    @foreach($fields as $field)
        <div class="col-sm-12">
            <label for="name">{{$field->display_name}}</label>
            {{-- String --}}
            @if($field->type == '1')
                <div class="form-group mt-0">
                    <div class="form-line">
                        @if($readonly == false)
                            <input type="text" id="normal_input" name="{{ 'field_'.$field->id }}"
                                   value="@if($item && $ItemTemplateId){!! $item_payload{'field_'.$field->id} !!}@else{!!old('default_value', $field->default_value) !!}@endif"
                                   class="form-control" placeholder="Enter {{$field->display_name}}">
                        @else
                            {{ $item_payload{'field_'.$field->id} }}
                        @endif

                    </div>
                </div>
            {{-- Number --}}
            @elseif($field->type == '2')
                <div class="form-group mt-0" id="number_default">
                    <div class="form-line">
                        @if($readonly == false)
                            <input type="number" id="number_input" name="{{ 'field_'.$field->id }}"
                                   value="@if($item && $ItemTemplateId){!! (int)$item_payload{'field_'.$field->id} !!}@else{!!old('default_value', $field->default_value) !!}@endif"
                                   class="form-control" placeholder="Enter {{$field->display_name}}">
                        @else
                            {!! (int)$item_payload{'field_'.$field->id} !!}
                        @endif
                    </div>
                </div>
            {{-- Dicimal --}}
            @elseif($field->type == '3')
                <div class="form-group mt-0" id="decimal_default">
                    <div class="form-line">
                        @if($readonly == false)
                            <input type="number" step="0.1" id="decimal_input" name="{{ 'field_'.$field->id }}"
                                   value="@if($item && $ItemTemplateId){!! (float)$item_payload{'field_'.$field->id} !!}@else{!!old('default_value', $field->default_value) !!}@endif"
                                   class="form-control" placeholder="Enter {{$field->display_name}}">
                        @else
                            {!! (float)$item_payload{'field_'.$field->id} !!}
                        @endif
                    </div>
                </div>
            {{-- Date --}}
            @elseif($field->type == '4')
                <div class="form-group mt-0" id="date_default">
                    <div class="form-line">
                        @if($readonly == false)
                            <input type="text" id="date_input" name="{!!'field_'.$field->id !!}"
                                   value="@if($item && $ItemTemplateId){!! $item_payload{'field_'.$field->id} !!}@else{!!old('default_value', $field->default_value) !!}@endif"
                                   class="datetimepicker_cumtom form-control" placeholder="Enter {{$field->display_name}}">
                        @else
                            {!! $item_payload{'field_'.$field->id} !!}
                        @endif
                    </div>
                </div>
            {{-- Multi select --}}
            @elseif($field->type == '5')
                <div class="row clearfix mt-0 ">
                    <div class="col-sm-12">
                        <div class="btn-group bootstrap-select form-control show-tick focused">
                            @if($readonly == false)
                                <select style="width: 100%" name="{{ 'field_'.$field->id }}" id="multi_select_input" class="js-example-basic-single form-control show-tick" tabindex="-98">
                                    <option value="">-- Please select {{$field->display_name}} --</option>
                                    @if($field->options)
                                        @foreach(explode(',', $field->options) as $option)
                                            <option value="{{$option}}" @if($item && $ItemTemplateId && $item_payload{'field_'.$field->id}== $option) selected @endif>{{$option}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @else
                                <p style="margin-top: -18px">{!! $item_payload{'field_'.$field->id} !!}</p>
                            @endif

                        </div>
                    </div>
                </div>
            @endif

        </div>
    @endforeach

    @if($readonly == false)
        <script>
            var dateFormat='YYYY-MM-DD';
            var timeFormat='HH:mm:ss';

            $(document).ready(function () {
                $('select').select2();
            });

            $('.datetimepicker_cumtom').bootstrapMaterialDatePicker({
                format: dateFormat + ' ' + timeFormat,
                clearButton: true,
                weekStart: 1
            });
        </script>
    @endif
@else
    <p class="text-center">This template have no fields yet!</p>
@endif

