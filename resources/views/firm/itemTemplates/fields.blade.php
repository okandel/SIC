<div class="col-sm-12">
    {{-- Display name field --}}
    <label for="display_name">Display Name</label>
    <div class="form-group mt-0">
        <div class="form-line">
            <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $item_template->display_name) }}" class="form-control" placeholder="Enter display name">
        </div>
        @if ($errors->has('display_name'))
            <div class="error" style="color: red">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('display_name') }}
            </div>
        @endif
    </div>

    {{-- Description field --}}
    <label for="description">Description</label>
    <div class="form-group mt-0">
        <div class="form-line">
            <input type="text" name="description" id="description" value="{{ old('description', $item_template->description) }}" class="form-control" placeholder="Enter description">
        </div>
        @if ($errors->has('description'))
            <div class="error" style="color: red">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('description') }}
            </div>
        @endif
    </div>

</div>

@csrf

@section('scripts')
    <script>
        // Disable Add button on submit
        $('#add_btn').on('click', function() {
            var btn = $(this);
            $(btn).prop("disabled", true);
            // add spinner to button
            $(btn).html(
                `<i class="fa fa-circle-o-notch fa-spin"></i> Saving...`
            );
            $("#add_form").submit();
        });

        $('#update_btn').on('click', function() {
            var btn = $(this);
            $(btn).prop("disabled", true);
            // add spinner to button
            $(btn).html(
                `<i class="fa fa-circle-o-notch fa-spin"></i> Saving...`
            );
            $("#update_form").submit();
        });
    </script>
@endsection