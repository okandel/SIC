@if(count($branches) > 0)
    <option value="">-- please select branch --</option>
    @foreach($branches as $branch)
        <option value="{{$branch->id}}" @if($branch->id == $mission->ClientBranchId) selected @endif>{{ $branch->display_name }}</option>
    @endforeach
@endif