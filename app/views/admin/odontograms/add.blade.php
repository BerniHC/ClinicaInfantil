@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    {{ Form::hidden('expedient_id', $expedient_id) }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label for="description" class="control-label">Descripción *</label>
            {{ Form::text('description', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if($errors->has('description'))
            <span class="help-block">{{ $errors->get('description')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('observation') ? 'has-error' : '' }}">
            <label for="observation" class="control-label">Observación</label>
            {{ Form::textarea('observation', '', array('class' => 'form-control', 'rows' => '3')) }}
            @if($errors->has('observation'))
            <span class="help-block">{{ $errors->get('observation')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-primary btn-loading" type="submit">Agregar</button>
    </div><!-- End Col -->
</form>
@stop