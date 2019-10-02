@section('styles')
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href='{{url("/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css")}}' rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href='{{url("/assets/plugins/bootstrap-select/css/bootstrap-select.css")}}' rel="stylesheet" />
    <link href='{{url("/assets/css/select2.min.css")}}' rel="stylesheet" />
@endsection

<div class="row">
    <div class="col-sm-8 pl-5">
        {{--Item name field--}}
        <div class="col-sm-12">
            <label for="name">Name</label>
            <div class="form-group mt-0">
                <div class="form-line">
                    <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}" class="form-control" placeholder="Enter name">
                </div>
                @if ($errors->has('name'))
                    <div class="error" style="color: red">
                        <i class="fa fa-times-circle"></i>
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
        </div>
        {{--Item description field--}}
        <div class="col-sm-12">
            <label for="last_name">Description</label>
            <div class="form-group mt-0">
                <div class="form-line">
                    <textarea name="description" rows="20" id="description" class="form-control" placeholder="Enter description">{{ old('description', $item->description) }}</textarea>
                </div>
                @if ($errors->has('description'))
                    <div class="error" style="color: red">
                        <i class="fa fa-times-circle"></i>
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>
        </div>
        {{--Item teemplate field--}}
        <label for="ItemTemplateId" style="color: blue; margin-bottom: 0">Item Templates</label>
        <div class="row clearfix mt-0 mb-5">
            <div class="col-sm-12">
                <div class="btn-group bootstrap-select form-control show-tick focused">
                    <select style="width: 100%" name="ItemTemplateId" id="ItemTemplateId" class="js-example-basic-single form-control show-tick" tabindex="-98">
                        <option value="">-- Please select item template --</option>
                        @if($item_templates)
                            @foreach($item_templates as $template)
                                <option value="{{ $template->id }}" @if($item->ItemTemplateId == $template->id) selected @endif>{{ $template->display_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div id="template_div">
        </div>
    </div>
    <div class="col-sm-1">
        <div  style="background-color: #e9e9e9; width: 2%; height: 92%; margin: auto"></div>
    </div>
    <div class="col-sm-3 pr-5">
        <img src="{{$item->image}}"  class="img-fluid img-thumbnail" id="image_preview" style="width: 100%; height: 300px" alt="image preview">

        <label for="image">Pick Image</label>
        <div class="form-group mt-0">
            <div class="form-line">
                <input type="file" name="image" id="image" value="{{ old('image', $item->image) }}" class="img-fluid img-thumbnail" placeholder="Upload image">
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
    <script src='{{ url("/assets/plugins/autosize/autosize.js")}}'></script> <!-- Autosize Plugin Js -->
    <script src='{{ url("/assets/plugins/momentjs/moment.js")}}'></script> <!-- Moment Plugin Js -->
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src='{{url("/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js")}}'></script>

    <script src='{{url("/assets/js/pages/forms/basic-form-elements.js")}}'></script>
    <script src='{{url("/assets/js/select2.min.js")}}'></script>
    <script>
        //Preview the image
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

        //Disable save button
        $('#save_btn').on('click', function() {
            var btn = $(this);
            $(btn).prop("disabled", true);
            // add spinner to button
            $(btn).html(
                `<i class="fa fa-circle-o-notch fa-spin"></i> Saving...`
            );
            $("#save_form").submit();
        });

        $(document).ready(function () {
            $('select').select2();

            //Render the item template
            $('#ItemTemplateId').on('change', function () {
                if ($('#ItemTemplateId').children("option:selected").val() !== '')
                {
                    $('#template_div').html("");
                    check_selected();
                } else {
                    $('#template_div').html("");
                }
            });
            check_selected();


        });

    </script>
@endsection
