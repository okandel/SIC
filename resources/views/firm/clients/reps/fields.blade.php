<input type="hidden" name="ClientId" value="{{ $ClientId }}">

<div class="row">
    <div class="col-sm-8 pl-5">
        <div class="row">
            <div class="col-sm-6">
                <label for="first_name">First Name</label>
                <div class="form-group mt-0">
                    <div class="form-line">
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $rep->first_name) }}" class="form-control" placeholder="Enter first name">
                    </div>
                    @if ($errors->has('first_name'))
                        <div class="error" style="color: red">
                            <i class="fa fa-times-circle"></i>
                            {{ $errors->first('first_name') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-sm-6"><label for="last_name">Last Name</label>
                <div class="form-group mt-0">
                    <div class="form-line">
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $rep->last_name) }}" class="form-control" placeholder="Enter last name">
                    </div>
                    @if ($errors->has('last_name'))
                        <div class="error" style="color: red">
                            <i class="fa fa-times-circle"></i>
                            {{ $errors->first('last_name') }}
                        </div>
                    @endif
                </div></div>
        </div>

        <label for="email_address">Email Address</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="email" name="email" id="email_address" value="{{ old('email', $rep->email) }}" class="form-control" placeholder="Enter email address">
            </div>
            @if ($errors->has('email'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('email') }}
                </div>
            @endif
        </div>

        <label for="phone">Phone Number</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="phone" id="phone" value="{{ old('phone', $rep->phone) }}" class="form-control" placeholder="Enter phone number">
            </div>
            @if ($errors->has('phone'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('phone') }}
                </div>
            @endif
        </div>

        <label for="phone">Position</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="position" id="position" value="{{ old('position', $rep->position) }}" class="form-control" placeholder="Enter position">
            </div>
            @if ($errors->has('position'))
                <div class="error" style="color: red">
                    {{ $errors->first('position') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-1">
        <div  style="background-color: #e9e9e9; width: 2%; height: 92%; margin: auto"></div>
    </div>
    <div class="col-sm-3 pr-5">
        <img src="{{$rep->image}}"  class="img-fluid img-thumbnail" id="image_preview" style="width: 100%; height: 250px" alt="image preview">

        <label for="image">Pick Image</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="file" name="image" id="image" value="{{ old('image', $rep->image) }}" class="img-fluid img-thumbnail" placeholder="Upload image">
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
<br>


@section('scripts')
    <script>
        //Preview Image
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

        //Disable Add & Save buttons
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