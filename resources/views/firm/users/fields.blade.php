
<div class="row">
    <div class="col-sm-6">
        <label for="first_name">First Name</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" class="form-control" placeholder="Enter first name">
            </div>
            @if ($errors->has('first_name'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('first_name') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        <label for="last_name">Last Name</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control" placeholder="Enter last name">
            </div>
            @if ($errors->has('last_name'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('last_name') }}
                </div>
            @endif
        </div>
    </div>
</div>

<label for="email_address">Email Address</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="email" name="email" id="email_address" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Enter email address">
    </div>
    @if ($errors->has('email'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('email') }}
        </div>
    @endif
</div>

<div class="row">
    <div class="col-sm-6">
        <label for="password">Password</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
            </div>
            @if ($errors->has('password'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6 float-right">
        <label for="password_confirmation">Confirm Password</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Enter password again">
            </div>
            @if ($errors->has('password'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('password') }}
                </div>
            @endif
        </div>
    </div>
</div>

<label class="clearfix" for="phone">Phone Number</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="Enter phone number">
    </div>
    @if ($errors->has('phone'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('phone') }}
        </div>
    @endif
</div>

@csrf
<br>

@section('scripts')
    <script>
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