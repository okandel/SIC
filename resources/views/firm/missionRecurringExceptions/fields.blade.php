@section('styles')
    <link rel="stylesheet" href='{{url("/assets/plugins/dropzone/dropzone.css")}}'>
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href='{{url("/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")}}' rel="stylesheet" />
    <link rel="stylesheet" href='{{url("/assets/css/select2.min.css")}}' />
@endsection

<input type="hidden" name="MissionId" value="{{$MissionId}}">

<label for="exception_type" style=" margin-bottom: 0">Exception Type</label>
<div class="form-control show-tick focused mb-5">
    <select style="width: 100%" name="exception_type" id="exception_type" class="js-example-basic-single form-control show-tick" tabindex="-98">
        <option value="">-- Please select exception type --</option>
        <option @if($exception->exception_type == 1) selected @endif value="1">Date</option>
        <option @if($exception->exception_type == 2) selected @endif value="2">Day of week</option>
        <option @if($exception->exception_type == 3) selected @endif value="3">Day of month</option>
    </select>
    @if ($errors->has('exception_type'))
        <div class="error" style="color: red; margin-top: 10px; margin-left: 15px">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('exception_type') }}
        </div>
    @endif
</div>

{{--exception_value (Date) field--}}
<div id="date_div">
    <label class="mb-0" for="date">Date</label>
    <div class="form-group mt-0">
        <div class="form-line">
            <input type="text" @if($exception->exception_type == 1) value="{{$exception->exception_value}}" @endif id="date" name="date_exception_value" class="datepicker form-control" placeholder="Pick date">
        </div>
    </div>
    @if ($errors->has('date_exception_value'))
        <div class="error" style="color: red; margin-top: 10px; margin-left: 15px">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('date_exception_value') }}
        </div>
    @endif
</div>

{{--exception_value (Day of week) field--}}
<div id="week_div">
    <label>Day of week</label>
    <div class="row ml-1 mb-2">
        @for($i=0; $i<7; $i++)
            <div class="col-sm-3">
                <input type="checkbox" @if($exception->exception_type==2 && in_array($i, explode(',', $exception->ExceptionValueInteger))) checked @endif id="_{{$i}}" class="filled-in" value="{{$i}}" name="week_exception_value[]">
                <label for="_{{$i}}">{{\App\Helpers\CommonHelper::GetDayOfWeekString($i)}}</label>
            </div>
        @endfor
    </div>
    @if ($errors->has('week_exception_value'))
        <div class="error" style="color: red; margin-top: 10px; margin-left: 15px">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('week_exception_value') }}
        </div>
    @endif
    <hr>
</div>

{{--exception_value (Day of month) field--}}
<div id="month_div">
    <label>Day of month</label>
    <div class="row mb-2 ml-2">
        @for($i=1; $i<=31; $i++)
            <div class="col-sm-1">
                <input type="checkbox" @if($exception->exception_type==3 && in_array($i, explode(',', $exception->ExceptionValueInteger))) checked @endif id="{{$i}}" class="filled-in" value="{{$i}}" name="month_exception_value[]">
                <label for="{{$i}}">{{$i}}</label>
            </div>
        @endfor
    </div>
    @if ($errors->has('month_exception_value'))
        <div class="error" style="color: red; margin-top: 10px; margin-left: 15px">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('month_exception_value') }}
        </div>
    @endif
    <hr>
</div>

@csrf
<br>

@section('scripts')
    <script src='{{ url("/assets/plugins/autosize/autosize.js")}}'></script> <!-- Autosize Plugin Js -->
    <script src='{{ url("/assets/plugins/momentjs/moment.js")}}'></script> <!-- Moment Plugin Js -->
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src='{{url("/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js")}}'></script>
    <script src='{{url("/assets/js/pages/forms/basic-form-elements.js")}}'></script>
    <script src='{{url("/assets/js/select2.min.js")}}'></script>

    <script>
        $(document).ready(function () {
            $('select').select2({
                placeholder: 'Select',
                allowClear: true
            });

            var exception_type = $('#exception_type');
            var date_div = $('#date_div');
            var week_div = $('#week_div');
            var month_div = $('#month_div');

            function check_selected_type() {
                if (exception_type.children("option:selected").val() === '1') { // Date
                    date_div.removeAttr('hidden');
                    week_div.attr('hidden', 'true');
                    month_div.attr('hidden', 'true');
                } else if (exception_type.children("option:selected").val() === '2') { // Day of week
                    week_div.removeAttr('hidden');
                    date_div.attr('hidden', 'true');
                    month_div.attr('hidden', 'true');
                } else if (exception_type.children("option:selected").val() === '3') { // Day of month
                    month_div.removeAttr('hidden');
                    date_div.attr('hidden', 'true');
                    week_div.attr('hidden', 'true');
                } else {
                    date_div.attr('hidden', 'true');
                    week_div.attr('hidden', 'true');
                    month_div.attr('hidden', 'true');
                }
            }
            check_selected_type();

            exception_type.change(function () {
                check_selected_type();
            })

        });
    </script>
@endsection