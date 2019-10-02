
<div class="row">
    <div class="col-sm-8 pl-5">
        <label for="title">Title</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="title" id="title" value="{{ old('title', $tutorial->title) }}" class="form-control" placeholder="Enter title">
            </div>
            @if ($errors->has('title'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('title') }}
                </div>
            @endif
        </div>

        <label for="content">Content</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="content" id="content" value="{{ old('content', $tutorial->content) }}" class="form-control" placeholder="Enter content">
            </div>
        </div>

    </div>
    <div class="col-sm-1">
        <div  style="background-color: #e9e9e9; width: 2%; height: 92%; margin: auto"></div>
    </div>
    <div class="col-sm-3 pr-5">
        <img   src="{{$tutorial->image}}"  class="img-fluid img-thumbnail" id="image_preview" style="width: 100%; height: 170px" alt="image preview">

        <label for="image">Pick Image</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="file" name="image" id="image" value="{{ old('image', $tutorial->image) }}" class="img-fluid img-thumbnail" placeholder="Upload image">
            </div>
            @if ($errors->has('image'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('image') }}
                </div>
            @endif
        </div>
    </div>
</div>

@csrf

@section('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function() {
            readURL(this);
        });

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
