@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
            <label for="category" class="control-label">Categoría *</label>
            {{ Form::select('category', $categories, '', array('class' => 'form-control')) }}
            @if( $errors->has('category') )
            <span class="help-block">{{ $errors->get('category')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label for="description" class="control-label">Descripción *</label>
            {{ Form::text('description', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('description') )
            <span class="help-block">{{ $errors->get('description')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
            <label for="price" class="control-label">Precio *</label>
            <div class="input-group">
                <span class="input-group-addon">₡</span>
                {{ Form::text('price', 0, array('class' => 'form-control')) }}
            </div>
            @if( $errors->has('price') )
            <span class="help-block">{{ $errors->get('price')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-primary btn-loading" type="submit">Agregar</button>
    </div><!-- End Col -->
</form>
@stop