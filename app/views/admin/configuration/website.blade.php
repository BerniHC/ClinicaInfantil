@section('content')
@include('layouts.configtabs', array('tab' => 'website'))
<br/>
@include('layouts.alerts', array('alert_info' => true))
        <form class="row" method="post">
            {{ Form::token() }}
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name" class="control-label">Nombre *</label>
                    {{ Form::text('name', Setting::get('website.name'), array('class' => 'form-control', 'maxlength' => '60')) }}
                    @if( $errors->has('name') )
                    <span class="help-block">{{ $errors->get('name')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('slogan') ? 'has-error' : '' }}">
                    <label for="slogan" class="control-label">Eslogan</label>
                    {{ Form::text('slogan', Setting::get('website.slogan'), array('class' => 'form-control', 'maxlength' => '60')) }}
                    @if( $errors->has('slogan') )
                    <span class="help-block">{{ $errors->get('slogan')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('admin') ? 'has-error' : '' }}">
                    <label for="admin" class="control-label">Administrador</label>
                    {{ Form::text('admin', Setting::get('website.admin'), array('class' => 'form-control', 'maxlength' => '60')) }}
                    @if( $errors->has('admin') )
                    <span class="help-block">{{ $errors->get('admin')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email" class="control-label">Correo Electrónico *</label>
                    {{ Form::text('email', Setting::get('website.email'), array('class' => 'form-control', 'maxlength' => '60')) }}
                    @if( $errors->has('email') )
                    <span class="help-block">{{ $errors->get('email')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('keywords') ? 'has-error' : '' }}">
                    <label for="keywords" class="control-label">Palabras claves</label>
                    {{ Form::text('keywords', Setting::get('website.keywords'), array('class' => 'form-control', 'maxlength' => '200')) }}
                    @if( $errors->has('keywords') )
                    <span class="help-block">{{ $errors->get('keywords')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label for="description" class="control-label">Descripción</label>
                    {{ Form::textarea('description', Setting::get('website.description'), array('class' => 'form-control', 'rows' => '3', 'maxlength' => '400')) }}
                    @if( $errors->has('description') )
                    <span class="help-block">{{ $errors->get('description')[0] }}</span>
                    @endif
                </div>
                <button class="btn btn-primary btn-loading" type="submit">Guardar</button>
            </div>
        </form>
@stop