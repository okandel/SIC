
@section('styles')
    <link rel="stylesheet" href='{{url("/assets/plugins/dropzone/dropzone.css")}}'>
    <link rel="stylesheet" href='{{url("/assets/css/select2.min.css")}}' />
@endsection

<input type="hidden" name="MissionId" value="{{ $MissionId }}">

<div class="row">
    <div class="col-sm-6">
        {{--Type field--}}
        <div class="row clearfix mt-0 mb-3">
            <div class="col-sm-12">
                <label for="TypeId" style="margin-bottom: 0">Task Type</label>
                <div class="form-control show-tick focused">
                    <select required style="width: 100%" name="TypeId" id="TypeId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                        <option value="">-- Please select type--</option>
                        @if($types)
                            @foreach($types as $type)
                                <option value="{{$type->id}}" @if($task->TypeId == $type->id) selected @endif>{{ $type->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            @if ($errors->has('TypeId'))
                <div class="error" style="color: red; margin-top: 5px; margin-left: 15px">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('TypeId') }}
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6">
        {{--Item field--}}
        <div class="row clearfix mt-0 mb-3">
            <div class="col-sm-12">
                <label for="ItemId" style="margin-bottom: 0">Task Item </label>
                <div class=" form-control show-tick focused">
                    <div class="dropdown-menu open" role="combobox"><ul class="dropdown-menu inner" role="listbox" aria-expanded="false"><li data-original-index="0" class="selected"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="true"><span class="text">-- Please select --</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="1"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">10</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">20</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="3"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">30</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="4"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">40</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="5"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">50</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div>
                    <select required style="width: 100%" name="ItemId" id="ItemId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                        <option value="">-- Please select item --</option>
                        @if($items)
                            @foreach($items as $item)
                                <option value="{{$item->id}}" @if($task->id && $task->item->id == $item->id) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @if ($errors->has('ItemId'))
                    <div class="error" style="color: red; margin-top: 20px">
                        <i class="fa fa-times-circle"></i>
                        {{ $errors->first('ItemId') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<label for="quantity">Task Quantity</label>
<div class="form-group mt-0">
    <div class="form-line">
        <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity', $task->quantity) }}" class="form-control" placeholder="Enter quantity">
    </div>
    @if ($errors->has('quantity'))
        <div class="error" style="color: red">
            <i class="fa fa-times-circle"></i>
            {{ $errors->first('quantity') }}
        </div>
    @endif
</div>

@csrf
<br>
@section('scripts')
    <script src='{{url("/assets/plugins/dropzone/dropzone.js")}}'></script> <!-- Dropzone Plugin Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script src='{{url("/assets/js/select2.min.js")}}'></script>

    <script>
        $(document).ready(function () {
            $('#TypeId').select2({
                placeholder: 'Select Type',
                allowClear: true
            });
            $('#ItemId').select2({
                placeholder: 'Select Item',
                allowClear: true
            });

            $('#add_btn').on('click', function () {
                $('#add_form').submit();
            });

            $('#update_btn').on('click', function () {
                $('#update_form').submit();
            });
        });
    </script>
    <script>
        if ($("#add_form").length > 0) {
            $("#add_form").validate({

                rules: {
                    ItemId: {
                        required: true,
                    },
                    TypeId: {
                        required: true,
                    },
                    quantity: {
                        required: true,
                        min: 1
                    }
                },
                messages: {

                    ItemId: {
                        required: "Please select task item",
                    },
                    TypeId: {
                        required: "Please select task type",
                    },
                    quantity: {
                        required: "Please enter quantity",
                        min: "The min value is 1"
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
                        url: "{{url('firm/mission'.'/'.$MissionId.'/tasks/store')}}",
                        type: "POST",
                        data: $('#add_form').serialize(),
                        success: function( response ) {
                            $('#add_btn').html('<i class="fa fa-plus-circle"></i> Add');
                            $('#TaskIdInput').val(response.TaskId);

                            var myDropzone = Dropzone.forElement(".dropzone");

                            myDropzone.processQueue();

                            myDropzone.on("complete", function (file) {
                                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                    // window.location.replace(response.firm.domain + '/firm/mission/' + response.MissionId + '/tasks');
                                    window.location.reload();
                                }
                                myDropzone.removeFile(file);
                            });

                            //Reset form after submitting
                            $('#TypeId').val("");
                            $('#ItemId').val("");
                            $('#quantity').val("");
                            $('#TypeId').select2({
                                placeholder: 'Select Type'
                            });
                            $('#ItemId').select2({
                                placeholder: 'Select Item'
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
                    ItemId: {
                        required: true,
                    },
                    TypeId: {
                        required: true,
                    },
                },
                messages: {

                    ItemId: {
                        required: "Please select task item",
                    },
                    TypeId: {
                        required: "Please select task type",
                    },

                },
                submitHandler: function(form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#update_btn').html('Sending..');
                    $.ajax({
                        url: "{{url('firm/mission'.'/'.$MissionId.'/tasks/'.$task->id.'/update')}}",
                        type: "POST",
                        data: $('#update_form').serialize(),
                        success: function( response ) {
                            $('#update_btn').html('<i class="fa fa-save"></i> Save');
                            $('#TaskIdInput').val(response.TaskId);

                            var myDropzone = Dropzone.forElement(".dropzone");

                            myDropzone.processQueue();

                            myDropzone.on("complete", function (file) {
                                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                                    // window.location.replace(response.firm.domain + '/firm/mission/' + response.MissionId + '/tasks');
                                    window.location.reload();
                                    // $('#attachmentsData').draw();

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

    </script>

    {{--  Get Task Attachments  --}}
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
                "order": [[ 0, "asc" ]],
                // sPaginationType: "full_numbers",
                ajax: {
                    url:"{{ url('/firm/mission/'.$MissionId.'/tasks/'.$task->id.'/attachments/get-attachments-data') }}",
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
                            if (oData.attachment_url){
                                // if (oData.mime_type === 'image/jpg' || oData.mime_type === 'image/jpeg' || oData.mime_type === 'image/png' || oData.mime_type === 'image/gif' || oData.mime_type === 'image/svg')
                                if (oData.mime_type.startsWith('image'))
                                {
                                    $(nTd).html(
                                        '<a href="/'+oData.attachment_url+'" target="_blank">' +
                                        '<img style="width: 70px; height: 70px" src="/'+oData.attachment_url+'" data-id="'+oData.id+'" class="img-fluid img-thumbnail">'+
                                        '</a>'
                                    );
                                    // } else if(oData.mime_type === 'video/webm' || oData.mime_type === 'video/mp4') {
                                } else if(oData.mime_type.startsWith('video')) {
                                    $(nTd).html(
                                        '<a href="/'+oData.attachment_url+'" target="_blank">' +
                                        '<img style="width: 70px; height: 70px" src="/uploads/defaults/video-icon.jpg" data-id="'+oData.id+'" class="img-fluid img-thumbnail">'+
                                        '</a>'
                                    )
                                } else {
                                    $(nTd).html(
                                        '<a href="/'+oData.attachment_url+'" target="_blank">' +
                                        '<img style="width: 70px; height: 70px" src="/uploads/defaults/attachment.png" data-id="'+oData.id+'" class="img-fluid img-thumbnail">'+
                                        '</a>'
                                    )
                                }
                            } else {
                                $(nTd).html(
                                    '<img style="width: 36px; height: 36px" src="/uploads/defaults/attachment.png" data-id="'+oData.id+'" class="img-fluid img-thumbnail">'
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
                                "<a href='javascript:' url='{{url('firm/mission/')}}/"+ {{$MissionId}} + "/tasks/" + {{$task->id}} + "/attachments/"+oData.id+"/delete' onclick='destroy(" + oData.id + ")' id='delete_" + oData.id + "' class='btn btn-xs btn-danger' title='Delete'><i class='fa fa-trash-alt'></i></a>"
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
@endsection
