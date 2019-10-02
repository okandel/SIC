@if(count($fields) > 0)
    <option value="">-- please select custom field --</option>
    @foreach($fields as $field)
        <option value="{{$field->id}}" >{{ $field->display_name }}</option>
    @endforeach
@else
    <option value="">-- no fields for selected item --</option>
@endif

