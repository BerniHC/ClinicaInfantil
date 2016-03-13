@section('content')
<div class="row">
    <div class="col-xs-12">
        <h3>Información de contacto</h3>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <img class="img-responsive" src="{{ URL::asset('images/boys.jpg') }}" alt="Niños riendo" />
                </div>
            </div>
            <div class="col-xs-12">
                <h5><strong>Ubicación</strong></h5>
                <ul class="fa-ul">
                    @foreach(Setting::get('contact.addresses') as $address)
                    <li><i class="fa-li fa fa-map-marker"></i><address>{{ $address }}</address></li>
                    @endforeach
                </ul>
            </div>
            <div class="col xs-12 col-md-6">
                <h5><strong>Teléfonos</strong></h5>
                <ul class="fa-ul">
                    @foreach(Setting::get('contact.telephones') as $telephone)
                    <li><i class="fa-li fa fa-phone"></i>+506 {{ $telephone }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col xs-12 col-md-6">
                <h5><strong>Correos Electrónicos</strong></h5>
                <ul class="fa-ul">
                    @foreach(Setting::get('contact.emails') as $email)
                    <li><i class="fa-li fa fa-envelope"></i><a href="mailto:{{ $email }}">{{ $email }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <h5><strong>¿Quienes Somos?</strong></h5>
        <p class="text-justify">
            {{ Setting::get('website.description') }}
        </p>
        <form method="post">
            <fieldset>
                <legend>Formulario de contacto</legend>
                @include('layouts.alerts', array('alert_info' => true))
                {{ Form::token() }}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="control-label" for="name">Nombre completo *</label>
                    {{ Form::text('name', '', array('class' => 'form-control', 'maxlength' => 50)) }}
                    @if( $errors->has('name') )
                    <span class="help-block">{{ $errors->get('name')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label class="control-label" for="email">Correo electrónico *</label>
                    {{ Form::text('email', '', array('class' => 'form-control', 'maxlength' => 60)) }}
                    @if( $errors->has('email') )
                    <span class="help-block">{{ $errors->get('email')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('telephone') ? 'has-error' : '' }}">
                    <label class="control-label" for="telephone">Teléfono</label>
                    {{ Form::text('telephone', '', array('class' => 'form-control', 'maxlength' => 15)) }}
                    @if( $errors->has('telephone') )
                    <span class="help-block">{{ $errors->get('telephone')[0] }}</span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                    <label class="control-label" for="message">Mensaje *</label>
                    {{ Form::textarea('message', '', array('class' => 'form-control', 'rows' => 2)) }}
                    @if( $errors->has('message') )
                    <span class="help-block">{{ $errors->get('message')[0] }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </fieldset>
        </form>
    </div>
</div>
<div class="push"></div>
@stop