@section('styles')
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href='{{url("/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")}}' rel="stylesheet" />
    <link rel="stylesheet" href='{{url("/assets/css/select2.min.css")}}' />
@endsection

{{--Clients field--}}
<div class="row clearfix mt-0 mb-3">
    <div class="col-sm-12">
        <label for="Client_IDs" style="margin-bottom: 0">Clients</label>
        <div class="form-control show-tick focused">
            <select style="width: 100%" name="Client_IDs[]" multiple="multiple" id="Client_IDs" class="js-example-basic-multi form-control show-tick" tabindex="-98">
                <option value="0">-- All Clients --</option>
                @if($clients)
                    @foreach($clients as $client)
                        <option value="{{$client->id}}" @if($announcement->Client_IDs && in_array($client->id, json_decode($announcement->Client_IDs))) selected @endif>{{ $client->contact_person }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    @if ($errors->has('Client_IDs'))
        <div class="error" style="color: red; margin-top: 5px; margin-left: 15px">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('Client_IDs') }}
        </div>
    @endif
</div>

{{--Employees field--}}
<div class="row clearfix mt-0 mb-3">
    <div class="col-sm-12">
        <label for="Emp_IDs" style="margin-bottom: 0">Employees</label>
        <div class=" form-control show-tick focused">
            <select style="width: 100%" name="Emp_IDs[]" multiple="multiple" id="Emp_IDs" class="js-example-basic-multi form-control show-tick" tabindex="-98">
                <option value="0">-- All Employees --</option>
                @if($employees)
                    @foreach($employees as $employee)
                        <option value="{{$employee->id}}" @if($announcement->Client_IDs && in_array($employee->id, json_decode($announcement->Emp_IDs))) selected @endif>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        @if ($errors->has('Emp_IDs'))
            <div class="error" style="color: red; margin-top: 20px">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('Emp_IDs') }}
            </div>
        @endif
    </div>
</div>

{{--Subjest field--}}
<div class="form-group mt-0">
    <label class="m-0" for="subject">Subject</label>
    <div class="form-line mt-0" style="margin-top: -10px">
        <input type="text" name="subject" id="subject" value="{{ old('subject', $announcement->subject) }}" class="form-control" placeholder="Enter subject">
    </div>
    @if ($errors->has('subject'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('subject') }}
        </div>
    @endif
</div>

{{--Message field--}}
<div class="form-group mt-0">
    <label class="m-0" for="message">Message</label>
    <div class="form-line mt-0" style="margin-top: -10px">
        <textarea name="message" style="min-height: 100px" id="message" class="form-control" placeholder="Enter message">{{ old('message', $announcement->message) }}</textarea>
    </div>
    @if ($errors->has('message'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('message') }}
        </div>
    @endif
</div>

{{--Published_at Field--}}
<label for="published_at">Published at</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="text" id="published_at" name="published_at" value="{{ old('published_at', $announcement->published_at) }}" class="datetimepicker form-control" placeholder="Pick published at">
    </div>
    @if ($errors->has('published_at'))
        <div class="error" style="color: red; margin-top: 10px;">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('published_at') }}
        </div>
    @endif
</div>

@csrf
<br>
@section('scripts')
    <script src='{{ url("/assets/plugins/jquery-sparkline/jquery.sparkline.js") }}'></script> <!-- Sparkline Plugin Js -->
    <script src='{{ url("/assets/plugins/bootstrap-notify/bootstrap-notify.js") }}'></script> <!-- Bootstrap Notify Plugin Js -->
    <script src='{{ url("/assets/js/pages/ui/notifications.js") }}'></script> <!-- Custom Js -->

    <script src='{{ url("/assets/plugins/autosize/autosize.js")}}'></script> <!-- Autosize Plugin Js -->
    <script src='{{ url("/assets/plugins/momentjs/moment.js")}}'></script> <!-- Moment Plugin Js -->
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src='{{url("/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js")}}'></script>
    <script src='{{url("/assets/js/pages/forms/basic-form-elements.js")}}'></script>
    <script src='{{url("/assets/js/select2.min.js")}}'></script>

    <script>
        $(document).ready(function () {
            $('#Client_IDs').select2({
                placeholder: 'Select Clients',
                allowClear: true
            });
            $('#Emp_IDs').select2({
                placeholder: 'Select Employees',
                allowClear: true
            });
        });

                @if(Session::has('success_message'))
        var msg = '{{ Session::get('success_message') }}' + ' ';
        {{ Session::forget('success_message') }}
        showNotification('bg-green', msg, 'top', 'right', null, null);
                @endif

                @if(Session::has('error_message'))
        var msg = '{{ Session::get('error_message') }}' + ' ';
        {{ Session::forget('error_message') }}
        showNotification('bg-red', msg, 'top', 'right', null, null);
        @endif
    </script>
@endsection
