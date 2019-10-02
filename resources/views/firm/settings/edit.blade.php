@extends('firm.layout.app')

@section('title') Edit setting @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-cog fa-1x"></i> Edit Setting</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('settings-edit') }}</p>
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
                    <h2> Edit Settings</h2>
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
                    {!! Form::model($setting, ['route' => ["settings.update", $setting->id], 'method' => 'patch', 'class'=> 'form-material m-t-40 row']) !!}
                        @include('firm.settings.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
