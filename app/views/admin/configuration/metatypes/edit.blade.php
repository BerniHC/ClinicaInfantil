@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('metagroup') ? 'has-error' : '' }}">
            <label for="metagroup" class="control-label">Grupo *</label>
            {{ Form::text('metagroup', $metatype->metagroup->description, array('class' => 'form-control', 'disabled')) }}
            @if( $errors->has('metagroup') )
            <span class="help-block">{{ $errors->get('metagroup')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label for="description" class="control-label">Descripción *</label>
            {{ Form::text('description', $metatype->description, array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('description') )
            <span class="help-block">{{ $errors->get('description')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-primary btn-loading" type="submit">Guardar</button>
    </div><!-- End Col -->
</form>
@stop