@extends('firm.layout.app')

@section('title') Edit vacation @endsection

@section('breadcrumbs')
    <div class="row">
        <div class="col-sm-3">
            <h4 class="ml-4 mt-3"><i class="fa fa-exclamation-triangle fa-1x"></i> Edit vacation</h4>
        </div>
        <div class="col-sm-9">
            <ul class="breadcrumb">
                <li class="breadcrumb-item float-md-right ml-3 mr-4">
                    <p>{{ Breadcrumbs::render('mission-recurring-exceptions-edit') }}</p>
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
                    <form method="post" action="{{ url('firm/mission-recurring-exceptions/'.$exception->id.'/update') }}">
                        @include('firm.missionRecurringExceptions.fields')
                        <button type="submit" class="btn btn-raised btn-primary m-t-15 waves-effect"><i class="fa fa-save"></i> Save</button>
                        @if($MissionId)
                            <a href="{{url('firm/mission-recurring-exceptions/index').'/'.$MissionId}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                        @else
                            <a href="{{url('firm/mission-recurring-exceptions/index')}}" class="btn btn-raised btn-danger m-t-15 waves-effect"><i class="fa fa-times-circle"></i> Cancel</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

