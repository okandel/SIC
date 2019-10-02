<div class="row">
    <div class="col-sm-8 pl-5">
        <label for="first_name">Contact Person</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $client->contact_person) }}" class="form-control" placeholder="Enter contact person">
            </div>
            @if ($errors->has('contact_person'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('contact_person') }}
                </div>
            @endif
        </div>

        <label for="email_address">Email Address</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="email" name="email" id="email_address" value="{{ old('email', $client->email) }}" class="form-control" placeholder="Enter email address">
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
                <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}" class="form-control" placeholder="Enter phone number">
            </div>
            @if ($errors->has('phone'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('phone') }}
                </div>
            @endif
        </div>

        <input type="checkbox" id="IsApproved" class="filled-in" name="IsApproved"
            @if ($client->IsApproved ==1) checked @endif
        >
        <label for="IsApproved">Approved</label>
    </div>
    <div class="col-sm-1">
        <div  style="background-color: #e9e9e9; width: 2%; height: 92%; margin: auto"></div>
    </div>
    <div class="col-sm-3 pr-5">
        <img src="{{$client->image?$client->image:'/uploads/defaults/client.png'}}"  class="img-fluid img-thumbnail" id="image_preview" style="width: 100%; height: 250px" alt="image preview">

        <label for="image">Pick Image</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="file" name="image" id="image" value="{{ old('image', $client->image) }}" class="img-fluid img-thumbnail" placeholder="Upload image">
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
