@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    {{ Form::hidden('odontogram_id', $odontogram_id) }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('piece') ? 'has-error' : '' }}">
            <label for="piece" class="control-label">Pieza *</label>
            {{ Form::text('piece', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if($errors->has('piece'))
            <span class="help-block">{{ $errors->get('piece')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('treatment') ? 'has-error' : '' }}">
            <label for="treatment" class="control-label">Tratamiento *</label>
            {{ Form::text('treatment', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if($errors->has('treatment'))
            <span class="help-block">{{ $errors->get('treatment')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('observation') ? 'has-error' : '' }}">
            <label for="observation" class="control-label">Observación *</label>
            {{ Form::textarea('observation', '', array('class' => 'form-control', 'rows' => '3')) }}
            @if($errors->has('observation'))
            <span class="help-block">{{ $errors->get('observation')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-primary btn-loading" type="submit">Agregar</button>
    </div><!-- End Col -->
</form>
@stop