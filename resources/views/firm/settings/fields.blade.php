<div class="row">
    <div class="col-md-12 pl-5">
    {!! Form::label('key', 'Key:') !!}
        <div class="form-group mt-0">
            <div class="form-line">
                {!! Form::text('key', null, ['class' => 'form-control', 'readonly' => 'true']) !!}       </div>
                @if ($errors->has('key'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('key') }}
                </div>
                @endif
        </div>

        {!! Form::label('value', 'Value:') !!}
        <div class="form-group mt-0">
            <div class="form-line">
            {!! Form::text('value', null, ['class' => 'form-control']) !!}
            </div>
            @if ($errors->has('value'))
                <div class="error" style="color: red">
                    <i class="fa fa-times-circle"></i>
                    {{ $errors->first('value') }}
                </div>
            @endif
        </div>

        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! url('firm/settings') !!}" class="btn btn-default">Cancel</a>
    </div>
     
</div>

@csrf
