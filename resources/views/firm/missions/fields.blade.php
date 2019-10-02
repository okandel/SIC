@section('styles')
    <link rel="stylesheet" href='{{url("/assets/plugins/dropzone/dropzone.css")}}'>
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href='{{url("/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")}}' rel="stylesheet" />
    <link rel="stylesheet" href='{{url("/assets/css/select2.min.css")}}' />

@endsection


{{--Title field--}}
<div class="form-group mt-0">
    <label class="m-0" for="title">Title</label>
    <div class="form-line mt-0" style="margin-top: -10px">
        <input type="text" name="title" id="title" value="{{ old('title', $mission->title) }}" class="form-control" placeholder="Enter title">
    </div>
    @if ($errors->has('title'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('title') }}
        </div>
    @endif
</div>

{{--Description field--}}
<div class="form-group mt-0">
    <label class="m-0" for="description">Description</label>
    <div class="form-line mt-0" style="margin-top: -10px">
        <textarea name="description" style="min-height: 100px" id="description" class="form-control" placeholder="Enter description">{{ old('description', $mission->description) }}</textarea>
    </div>
    @if ($errors->has('description'))
    <div class="error" style="color: red">
        <i class="fa fa-times-circle"></i>
        {{ $errors->first('description') }}
    </div>
    @endif
</div>

{{--Employee field--}}
<div class="row clearfix mt-0 mb-3">
    <div class="col-sm-12">
        <label for="EmpId" style=" margin-bottom: 0">Employee</label>
        <div class="form-control show-tick focused">
            <select style="width: 100%" name="EmpId" id="EmpId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                <option value="">-- Please select employee --</option>
                @if($employees)
                    @foreach($employees as $employee)
                        <option value="{{ old('EmpId', $employee->id) }}" @if($mission->EmpId == $employee->id) selected @endif>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        @if ($errors->has('EmpId'))
            <div class="error" style="color: red; margin-top: 10px; margin-left: 15px">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('EmpId') }}
            </div>
        @endif
    </div>
</div>

{{--Client Branch field--}}
<div class="row clearfix mt-0 mb-3">
    <div class="col-sm-6">
        <label for="ClientId" style="margin-bottom: 0">Client <span class="text-small">(select client then select client branch)</span></label>
        <div class="form-control show-tick focused">
            <select style="width: 100%" name="ClientId" id="ClientId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                <option value="">-- Please select client --</option>
                @if($clients)
                    @foreach($clients as $client)
                        <option value="{{$client->id}}" @if($_clientId == $client->id) selected @endif>{{ $client->contact_person }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        @if ($errors->has('ClientId'))
            <div class="error" style="color: red; margin-top: 15px; margin-left: 15px">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('ClientId') }}
            </div>
        @endif
    </div>
    <div class="col-sm-6" id="BranchDiv">
        <label for="ClientBranchId" style="margin-bottom: 0">Client Branch</label>
        <div class=" form-control show-tick focused">
            <select style="width: 100%" disabled name="ClientBranchId" id="ClientBranchId" class="js-example-basic-single form-control show-tick" tabindex="-98">
            </select>
        </div>
        @if ($errors->has('ClientBranchId'))
            <div class="error" style="color: red; margin-top: 15px; margin-left: 15px">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('ClientBranchId') }}
            </div>
        @endif
    </div>
</div>

{{--Mission Priority field--}}
<div class="row clearfix mt-0 mb-3">
    <div class="col-sm-12">
        <label for="PriorityId" style="margin-bottom: 0">Mission Priority</label>
        <div class="form-control show-tick focused">
            <select style="width: 100%" name="PriorityId" id="PriorityId" class="form-control show-tick js-example-basic-single" tabindex="-98">
                <option value="">-- Please select priority --</option>
                @if($priorities)
                    @foreach($priorities as $priority)
                        <option value="{{$priority->id}}" @if($mission->PriorityId == $priority->id) selected @endif>{{ $priority->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    @if ($errors->has('PriorityId'))
        <div class="error" style="color: red; margin-top: 10px; margin-left: 15px">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('PriorityId') }}
        </div>
    @endif
</div>

{{--Start & Complete Date Field--}}
<div class="row mb-0">
    <div class="col-sm-6">
        {{--Start Date Field--}}
        <label for="start_date">Start Date</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" id="start_date" name="start_date" value="{{ old('start_date', $mission->start_date) }}" class="datetimepicker form-control" placeholder="Enter start date">
            </div>
            @if ($errors->has('start_date'))
                <div class="error" style="color: red; margin-top: 10px;">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('start_date') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        {{--Complete Date Field--}}
        <label for="complete_date">Complete Date</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" id="complete_date" name="complete_date" value="{{ old('complete_date', $mission->complete_date) }}" class="datetimepicker form-control" placeholder="Enter complete date">
            </div>
        </div>
    </div>
</div>

{{---------------------------------------------------------------------------------------------}}
{{--Mission IsRecuiring field--}}
<div class="row ml-1 mb-2">
    <input type="checkbox" id="IsRecurring" class="filled-in" @if($mission->recurring_type != null) checked @endif value="true" name="IsRecurring">
    <label for="IsRecurring"> Is Recurring?</label>
</div>

{{--Mission Recuiring Type field--}}
<div class="row clearfix mt-0 mb-3" id="recurring_type_div">
    <div class="col-sm-12">
        <label for="recurring_type" style="margin-bottom: 0">Mission Recurring Type</label>
        <div class="form-control show-tick focused">
            <select style="width: 100%" name="recurring_type" id="recurring_type" class="form-control show-tick js-example-basic-single" tabindex="-98">
                <option value="">-- Please select recurring type --</option>
                <option @if($mission->recurring_type == 1) selected @endif value="1">Weekly</option>
                <option @if($mission->recurring_type == 2) selected @endif value="2">Monthly</option>
                <option @if($mission->recurring_type == 3) selected @endif value="3">Date Range</option>
            </select>
        </div>
    </div>
</div>

{{--Mission Recuiring Type (Weekly) field--}}
<div id="weekly_div">
    <label for="weekly_repeat_value">Mission Recurring Week Days</label>
    <div class="row ml-1 mb-2">
        @for($i=0; $i<7; $i++)
            <div class="col-sm-3">
                <input type="checkbox" id="_{{$i}}" @if($mission->recurring_type==1 && in_array($i, json_decode($mission->repeat_value))) checked @endif class="filled-in" value="{{$i}}" name="weekly_repeat_value[]">
                <label for="_{{$i}}">{{\App\Helpers\CommonHelper::GetDayOfWeekString($i)}}</label>
            </div>
        @endfor
    </div>
    @if ($errors->has('weekly_repeat_value'))
        <div class="error" style="color: red; margin-top: 10px;">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('weekly_repeat_value') }}
        </div>
    @endif
    <hr>
</div>

{{--Mission Recuiring Type (Monthly) field--}}
<div id="monthly_div">
    <label for="monthly_repeat_value">Mission Recurring Month Days</label>
    <div class="row mb-2">
        @for($i=1; $i<=31; $i++)
            <div class="col-sm-1">
                <input type="checkbox" id="{{$i}}" @if($mission->recurring_type==2 && in_array($i, json_decode($mission->repeat_value))) checked @endif class="filled-in" value="{{$i}}" name="monthly_repeat_value[]">
                <label for="{{$i}}">{{$i}}</label>
            </div>
        @endfor
    </div>
    @if ($errors->has('monthly_repeat_value'))
        <div class="error" style="color: red; margin-top: 10px;">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('monthly_repeat_value') }}
        </div>
    @endif
    <hr>
</div>

{{--Mission Recuiring Type (Date range) field--}}
<div id="date_range_div" class="row mb-0">
    <div class="col-sm-6">
        {{--Start Date Range Field--}}
        <label for="start_date_range">Start Date Range</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" id="start_date_range" name="start_date_range"
                       class="datepicker form-control" placeholder="Enter start date range"
                       @if($mission->recurring_type==3) value="{{ explode(',', json_decode($mission->repeat_value))[0] }}" @endif
                >
            </div>
        </div>
        @if ($errors->has('start_date_range'))
            <div class="error" style="color: red; margin-top: 10px;">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('start_date_range') }}
            </div>
        @endif
    </div>
    <div class="col-sm-6">
        {{--End Date Range Field--}}
        <label for="end_date_range">End Date Range</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="text" id="end_date_range" name="end_date_range"
                       class="datepicker form-control" placeholder="Enter end date range"
                       @if($mission->recurring_type==3) value="{{ explode(',', json_decode($mission->repeat_value))[1] }}" @endif
                >
            </div>
        </div>
        @if ($errors->has('end_date_range'))
            <div class="error" style="color: red; margin-top: 10px;">
                <i class="fa fa-times-circle"></i>
                {{ $errors->first('end_date_range') }}
            </div>
        @endif
    </div>
</div>

{{--Mission Total Cycle field--}}
<div class="row" id="limited_div">
    <div class="col-sm-12">
        <input type="checkbox" id="IsLimited" class="filled-in" @if($mission->total_cycle != null) checked @endif value="true" name="IsLimited">
        <label for="IsLimited">Is mission limited occurrence?</label>
    </div>
    <div class="col-sm-12" id="total_cycle_div">
        <div class="form-group ">
            <div class="form-line">
                <input min="0" type="number" id="total_cycle" value="{{ old('total_cycle', $mission->total_cycle) }}" name="total_cycle" class="form-control">
                <label for="total_cycle" class="form-label">Repeat number</label>
            </div>
        </div>
    </div>
</div>

@csrf

@section('scripts')
    <script src='{{ url("/assets/plugins/autosize/autosize.js")}}'></script> <!-- Autosize Plugin Js -->
    <script src='{{ url("/assets/plugins/momentjs/moment.js")}}'></script> <!-- Moment Plugin Js -->

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src='{{url("/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js")}}'></script>
    <script src='{{url("/assets/js/pages/forms/basic-form-elements.js")}}'></script>

    <script src='{{url("/assets/js/select2.min.js")}}'></script>

    <script src='{{url("/assets/plugins/dropzone/dropzone.js")}}'></script> <!-- Dropzone Plugin Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

    <script>

        $(document).ready(function () {
            $('select').select2({
                placeholder: 'Select',
                allowClear: true
            });

            $(document).on('click', '#add_btn', function () {
                $('.error').css({'color': 'red', 'font-size': '13px'});
            });
            $(document).on('click', '#update_btn', function () {
                $('.error').css({'color': 'red', 'font-size': '13px'});
            });

            $('#add_btn').on('click', function () {
                $('#add_form').submit();
            });

            $('#update_btn').on('click', function () {
                $('#update_form').submit();
            });

            // //For min & max date
            $('#start_date').bind('change click load', function (e, date) {
                $('#complete_date').bootstrapMaterialDatePicker('setMinDate', date);
            });
            if ($('#start_date').val()) {
                $('#complete_date').bootstrapMaterialDatePicker('setMinDate', $('#start_date').val());
            }


            $('#ClientId').on('change', function () {
                if ($('#ClientId').children("option:selected").val() !== '') {
                    check_selected();
                } else {
                    $('#ClientBranchId').attr('disabled', 'true');
                    $('#ClientBranchId').select2({
                        placeholder: 'Select client first',
                        allowClear: true
                    })
                }
            });

            function check_selected() {
                var ctrl = $('#ClientId');
                var id = $(ctrl).val();
                        @if ($mission->id)
                var url = "{{ url('firm/missions/client-branches') }}" + "/" + id + "/" + "{{$mission->id}}";
                        @else
                var url = "{{ url('firm/missions/client-branches') }}" + "/" + id;
                @endif
                $.ajax({
                    url: url,
                    method: "get",
                    success: function (data) {
                        if (data) {
                            $('#ClientBranchId').removeAttr('disabled').html(data);
                            $('#ClientBranchId').select2({
                                placeholder: 'Select client branch',
                                allowClear: true
                            })
                        } else {
                            $('#ClientBranchId').attr('disabled', 'true').html(data);
                            $('#ClientBranchId').select2({
                                placeholder: 'No branches for selected client',
                                allowClear: true
                            })
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            }

            if ($('#ClientId').val() != '') {
                check_selected();
            }
        });

        if ($("#add_form").length > 0) {
            $("#add_form").validate({
                rules: {
                    EmpId: {
                        required: true,
                    },
                    PriorityId: {
                        required: true,
                    },
                    ClientId: {
                        required: true,
                    },
                    ClientBranchId: {
                        required: true,
                    },
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                    start_date: {
                        required: function()
                        {
                            return ($("#complete_date").val() !== "");
                        },
                    },
                    recurring_type: {
                        required: function()
                        {
                            return ($("#IsRecurring").val() !== "");
                        },
                    },
                    'weekly_repeat_value[]': {
                        required: function()
                        {
                            return ($("#recurring_type").val() === "1");
                        },
                    },
                    'monthly_repeat_value[]': {
                        required: function()
                        {
                            return ($("#recurring_type").val() === "2");
                        },
                    },
                    'start_date_range': {
                        required: function()
                        {
                            return ($("#recurring_type").val() === "3");
                        },
                    },
                    'end_date_range': {
                        required: function()
                        {
                            return ($("#recurring_type").val() === "3");
                        },
                    },
                },
                messages: {
                    EmpId: {
                        required: "Please select Employee",
                    },
                    PriorityId: {
                        required: "Please select Priority",
                    },
                    ClientId: {
                        required: "Please select Client",
                    },
                    ClientBranchId: {
                        required: "Please select Client Branch",
                    },
                    title: {
                        required: "Please enter Title",
                    },
                    description: {
                        required: "Please enter Description",
                    },
                    start_date: {
                        required: "Please pick start date field"
                    },
                    recurring_type: {
                        required: "Please select recurring type"
                    },
                    'weekly_repeat_value[]': {
                        required: "Please select weekly repeat value"
                    },
                    'monthly_repeat_value[]': {
                        required: "Please select monthly repeat value"
                    },
                    start_date_range: {
                        required: "Please start date range repeat value"
                    },
                    end_date_range: {
                        required: "Please end date range repeat value"
                    }

                },
                submitHandler: function(form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#add_btn').html('Sending..');
                    $.ajax({
                        url: "{{url('firm/missions/store')}}",
                        type: "POST",
                        data: $('#add_form').serialize(),
                        success: function( response ) {
                            $('#add_btn').html('<i class="fa fa-plus-circle"></i> Add');
                            $('#MissionIdInput').val(response.MissionId);

                            var myDropzone = Dropzone.forElement(".dropzone");
                            myDropzone.processQueue();

                            myDropzone.on("complete", function (file) {
                                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                    // window.location.replace(response.firm.domain + '/firm/missions/index');
                                    window.location.reload();
                                }
                                myDropzone.removeFile(file);
                            });

                            //Reset form after submitting
                            $('input, textarea, select').val("");
                            $('input:checkbox').prop('checked', false);
                            $('select').select2({
                                placeholder: 'Select'
                            });

                            //Show the response success message
                            $('#msg_success_div').removeClass('d-none');
                            $('#res_success_message').show();
                            $('#res_success_message').html(response.success_message);

                            setTimeout(function(){
                                $('#msg_success_div').addClass('d-none');
                                $('#res_success_message').hide();
                            },3000);
                        },
                        error: function (response) {
                            //Show the response error message
                            $('#msg_error_div').removeClass('d-none');
                            $('#res_error_message').show();
                            $('#res_error_message').html(response.error_message);

                            setTimeout(function(){
                                $('#msg_error_div').addClass('d-none');
                                $('#res_error_message').hide();
                            },3000);
                        }
                    });
                }
            })
        }

        if ($("#update_form").length > 0) {
            $("#update_form").validate({
                rules: {
                    EmpId: {
                        required: true,
                    },
                    PriorityId: {
                        required: true,
                    },
                    ClientId: {
                        required: true,
                    },
                    ClientBranchId: {
                        required: true,
                    },
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
                    },
                    start_date: {
                        required: function()
                        {
                            return ($("#complete_date").val() !== "");
                        },
                    },
                    recurring_type: {
                        required: function()
                        {
                            return ($("#IsRecurring").val() !== "");
                        },
                    },
                    'weekly_repeat_value[]': {
                        required: function()
                        {
                            return ($("#recurring_type").val() === "1");
                        },
                    },
                    'monthly_repeat_value[]': {
                        required: function()
                        {
                            return ($("#recurring_type").val() === "2");
                        },
                    },
                    'start_date_range': {
                        required: function()
                        {
                            return ($("#recurring_type").val() === "3");
                        },
                    },
                    'end_date_range': {
                        required: function()
                        {
                            return ($("#recurring_type").val() === "3");
                        },
                    },
                },
                messages: {
                    EmpId: {
                        required: "Please select Employee",
                    },
                    PriorityId: {
                        required: "Please select Priority",
                    },
                    ClientId: {
                        required: "Please select Client",
                    },
                    ClientBranchId: {
                        required: "Please select Client Branch",
                    },
                    title: {
                        required: "Please enter Title",
                    },
                    description: {
                        required: "Please enter Description",
                    },
                    start_date: {
                        required: "Please pick start date field"
                    },
                    recurring_type: {
                        required: "Please select recurring type"
                    },
                    'weekly_repeat_value[]': {
                        required: "Please select weekly repeat value"
                    },
                    'monthly_repeat_value[]': {
                        required: "Please select monthly repeat value"
                    },
                    start_date_range: {
                        required: "Please start date range repeat value"
                    },
                    end_date_range: {
                        required: "Please end date range repeat value"
                    }

                },
                submitHandler: function (form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#update_btn').html('Sending..');
                    $.ajax({
                        url: "{{url('firm/missions'.'/'.$MissionId.'/update')}}",
                        type: "POST",
                        data: $('#update_form').serialize(),
                        success: function (response) {
                            $('#update_btn').html('<i class="fa fa-save"></i> Save');
                            $('#MissionIdInput').val(response.MissionId);

                            var myDropzone = Dropzone.forElement(".dropzone");
                            myDropzone.processQueue();

                            myDropzone.on("complete", function (file) {
                                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                    // window.location.replace(response.firm.domain + '/firm/missions/index');
                                    window.location.reload();
                                }
                                myDropzone.removeFile(file);
                            });

                            //Reset form after submitting
                            $('#TypeId').val(response.TypeId);
                            $('#ItemId').val(response.ItemId);

                            //Show the response success message
                            $('#msg_success_div').removeClass('d-none');
                            $('#res_success_message').show();
                            $('#res_success_message').html(response.success_message);

                            setTimeout(function () {
                                $('#msg_success_div').addClass('d-none');
                                $('#res_success_message').hide();
                            }, 3000);
                        },
                        error: function (response) {
                            //Show the response error message
                            $('#msg_error_div').removeClass('d-none');
                            $('#res_error_message').show();
                            $('#res_error_message').html(response.error_message);

                            setTimeout(function () {
                                $('#msg_error_div').addClass('d-none');
                                $('#res_error_message').hide();
                            }, 3000);
                        }
                    });
                }
            })
        }

    </script>

    {{--  Get Attachments  --}}
    <link rel="stylesheet" href='{{ url("/assets/css/datatables.min.css") }}'>
    <link rel="stylesheet" href='{{ url("/assets/css/dataTables.bootstrap.min.css") }}'>
    <script src='{{ url("/assets/plugins/sweetalert/sweetalert.min.js")}}'></script>
    <script src='{{ url("/assets/plugins/sweetalert/jquery.sweet-alert.custom.js")}}'></script>
    <script src='{{ url("/assets/js/datatables.min.js") }}'></script>
    <script src='{{ url("/assets/js/dataTables.bootstrap.min.js") }}'></script>
    <script>
        $(document).ready(function () {
            attachmentsTable = $('#attachmentsData').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                "order": [[0, "asc"]],
                // sPaginationType: "full_numbers",
                ajax: {
                    url: "{{ url('/firm/missions/'.$MissionId.'/attachments/get-attachments-data') }}",
                    method: 'POST',
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (d) {
                        //for search

                    }
                },
                type: 'GET',
                columns: [
                    {
                        data: 'id', name: 'id',
                        "searchable": true,
                        "sortable": true,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(oData.id);
                        }
                    },
                    {
                        data: "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if (oData.attachment_url) {
                                // if (oData.mime_type === 'image/jpg' || oData.mime_type === 'image/jpeg' || oData.mime_type === 'image/png' || oData.mime_type === 'image/gif' || oData.mime_type === 'image/svg')
                                if (oData.mime_type.startsWith('image')) {
                                    $(nTd).html(
                                        '<a href="/' + oData.attachment_url + '" target="_blank">' +
                                        '<img style="width: 70px; height: 70px" src="/' + oData.attachment_url + '" data-id="' + oData.id + '" class="img-fluid img-thumbnail">' +
                                        '</a>'
                                    );
                                    // } else if(oData.mime_type === 'video/webm' || oData.mime_type === 'video/mp4') {
                                } else if (oData.mime_type.startsWith('video')) {
                                    $(nTd).html(
                                        '<a href="/' + oData.attachment_url + '" target="_blank">' +
                                        '<img style="width: 70px; height: 70px" src="/uploads/defaults/video-icon.jpg" data-id="' + oData.id + '" class="img-fluid img-thumbnail">' +
                                        '</a>'
                                    )
                                } else {
                                    $(nTd).html(
                                        '<a href="/' + oData.attachment_url + '" target="_blank">' +
                                        '<img style="width: 70px; height: 70px" src="/uploads/defaults/attachment.png" data-id="' + oData.id + '" class="img-fluid img-thumbnail">' +
                                        '</a>'
                                    )
                                }
                            } else {
                                $(nTd).html(
                                    '<img style="width: 36px; height: 36px" src="/uploads/defaults/attachment.png" data-id="' + oData.id + '" class="img-fluid img-thumbnail">'
                                );
                            }
                        }
                    },
                    {
                        data: 'mime_type', name: 'mime_type',
                        "searchable": true,
                        "sortable": true,
                    },
                    {
                        "data": "id",
                        "searchable": false,
                        "sortable": false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                "<a href='javascript:' url='{{url('firm/missions/')}}/" + {{$MissionId}} +"/attachments/" + oData.id + "/delete' onclick='destroy(" + oData.id + ")' id='delete_" + oData.id + "' class='btn btn-xs btn-danger' title='Delete'><i class='fa fa-trash-alt'></i></a>"
                            );
                        }
                    }
                ]
            });

        });
        function destroy(id) {
            swal({
                title: "Are you sure?",
                text: "You are about to delete this entity!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete!",
                closeOnConfirm: false
            }, function(){
                swal.close();
                window.location.href = $('#delete_'+id).attr('url');
            });
        }
    </script>

    {{-- Mission Recurring --}}
    <script>
        $(document).ready(function () {
            is_recurring = $('#IsRecurring');
            recurring_type_div = $('#recurring_type_div');
            recurring_type = $('#recurring_type');
            weekly_div = $('#weekly_div');
            monthly_div = $('#monthly_div');
            date_range_div = $('#date_range_div');
            limited_div = $('#limited_div');
            is_limited = $('#IsLimited');
            total_cycle_div = $('#total_cycle_div');

            recurring_type_div.attr('hidden', 'true');
            weekly_div.attr('hidden', 'true');
            monthly_div.attr('hidden', 'true');
            date_range_div.attr('hidden', 'true');
            limited_div.attr('hidden', 'true');

            function checkIsRecurring() {
                if (is_recurring.is(':checked')) {
                    recurring_type_div.removeAttr('hidden');
                    limited_div.removeAttr('hidden');
                } else {
                    recurring_type_div.attr('hidden', 'true');
                    weekly_div.attr('hidden', 'true');
                    monthly_div.attr('hidden', 'true');
                    date_range_div.attr('hidden', 'true');
                    limited_div.attr('hidden', 'true');
                    recurring_type.prop('selectedIndex', 0);
                    recurring_type.select2({
                        placeholder: 'Select',
                        allowClear: true
                    });
                }
            }

            checkIsRecurring();

            is_recurring.change(function () {
                checkIsRecurring();
            });

            function check_selected_recurring_type() {
                if (recurring_type.children("option:selected").val() === "1") { // Weekly
                    weekly_div.removeAttr('hidden');
                    monthly_div.attr('hidden', 'true');
                    date_range_div.attr('hidden', 'true');
                } else if (recurring_type.children("option:selected").val() === "2") { // Monthly
                    monthly_div.removeAttr('hidden');
                    weekly_div.attr('hidden', 'true');
                    date_range_div.attr('hidden', 'true');
                } else if (recurring_type.children("option:selected").val() === "3") { // Date range
                    date_range_div.removeAttr('hidden');
                    weekly_div.attr('hidden', 'true');
                    monthly_div.attr('hidden', 'true');
                } else {
                    weekly_div.attr('hidden', 'true');
                    monthly_div.attr('hidden', 'true');
                    date_range_div.attr('hidden', 'true');
                }
            }

            check_selected_recurring_type();

            recurring_type.change(function () {
                check_selected_recurring_type();
            });


            function checkIsLimited() {
                if (is_limited.is(':checked')) {
                    total_cycle_div.removeAttr('hidden');
                } else {
                    total_cycle_div.attr('hidden', 'true');
                }
            }

            checkIsLimited();

            is_limited.change(function () {
                checkIsLimited();
            })

            // //For min & max date
            $('#start_date_range').bind('change click load', function (e, date) {
                $('#end_date_range').bootstrapMaterialDatePicker('setMinDate', date);
            });
            if ($('#start_date_range').val()) {
                $('#end_date_range').bootstrapMaterialDatePicker('setMinDate', $('#start_date_range').val());
            }
        })
    </script>
@endsection
