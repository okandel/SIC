@extends('firm.layout.app')

@section('title') Edit item @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-th fa-1x"></i> Edit Item</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('items-edit') }}</p>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="card">
                <div class="header">
                    @if ($errors->any())
                        <div class="alert bg-red mt-2">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="body">
                    <form id="save_form" method="post" action="{{ url('firm/items/'.$item->id.'/update') }}" enctype="multipart/form-data">
                        @include('firm.items.fields')
                        <button id="save_btn" type="submit" class="btn btn-raised btn-primary waves-effect"><i class="fa fa-save"></i> Save</button>
                        <a href="{{url('firm/items/index')}}" class="btn btn-raised btn-danger waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function check_selected() {
        if ($('#ItemTemplateId').children("option:selected").val() !== '') {
            var ctrl = $('#ItemTemplateId');
            var id=$(ctrl).val();
            var url="{{ url('firm/items/item-templates') }}" + "/" +id+ "/" +"{{$item->id}}";
            $.ajax({
                url: url,
                method:"get",
                data: {'ItemTemplateId' : $('#ItemTemplateId').children("option:selected").val() },
                success: function (data) {
                    $('#template_div').html(data);
                },
                error:function (err) {
                    console.log(err);
                }
            })
        }

    }
</script>