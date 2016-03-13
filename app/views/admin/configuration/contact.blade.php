@section('content')
@include('layouts.configtabs', array('tab' => 'contact'))
<br/>
@include('layouts.alerts', array('alert_info' => true))
<form class="row" method="post">
    {{ Form::token() }}
    <div class="col-md-6">
        @foreach($emails as $email)
        <div class="form-group email">
            <label for="emails" class="control-label">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                {{ Form::text('emails[]', $email, array('class' => 'form-control', 'maxlenght' => 60)) }}
            </div>
        </div>
        @endforeach
        @if($emails == null)
        <div class="form-group email">
            <label for="emails" class="control-label">Correo Electrónico</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                {{ Form::text('emails[]', '', array('class' => 'form-control', 'maxlenght' => 60)) }}
            </div>
        </div>
        @endif
        <div class="form-group">
            <a class="clone" href="#" data-field=".email">Agregar correo electrónico</a>
        </div>
        @foreach($telephones as $telephone)
        <div class="form-group telephone">
            <label for="telephones[]" class="control-label">Teléfono</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                {{ Form::text('telephones[]', $telephone, array('class' => 'form-control', 'maxlenght' => 15)) }}
            </div>
        </div>
        @endforeach
        @if($telephones == null)
        <div class="form-group telephone">
            <label for="telephones[]" class="control-label">Teléfono</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                {{ Form::text('telephones[]', '', array('class' => 'form-control', 'maxlenght' => 15)) }}
            </div>
        </div>
        @endif
        <div class="form-group">
            <a class="clone" href="#" data-field=".telephone">Agregar teléfono</a>
        </div>
        @foreach($addresses as $address)
        <div class="form-group address">
            <label for="addresses" class="control-label">Dirección</label>
            {{ Form::textarea('addresses[]', $address, array('class' => 'form-control', 'rows' => 2)) }}
        </div>
        @endforeach
        @if($addresses == null)
        <div class="form-group address">
            <label for="addresses" class="control-label">Dirección</label>
            {{ Form::textarea('addresses[]', '', array('class' => 'form-control', 'rows' => 2)) }}
        </div>
        @endif
        <div class="form-group">
            <a class="clone" href="#" data-field=".address">Agregar dirección</a>
        </div>
        <div class="form-group">
            <label for="facebook" class="control-label">Facebook</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                {{ Form::text('facebook', Setting::get('contact.facebook'), array('class' => 'form-control', 'maxlenght' => 100, 'placeholder' => 'http://www.facebook.com/miusuario')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="twitter" class="control-label">Twitter</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-twitter"></i></span>
                {{ Form::text('twitter', Setting::get('contact.twitter'), array('class' => 'form-control', 'maxlenght' => 100, 'placeholder' => 'http://www.twitter.com/miusuario')) }}
            </div>
        </div>
        <div class="form-group">
            <label for="google-plus" class="control-label">Google+</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-google-plus"></i></span>
                {{ Form::text('google-plus', Setting::get('contact.google-plus'), array('class' => 'form-control', 'maxlenght' => 100, 'placeholder' => 'http://www.plus.google.com/miusuario')) }}
            </div>
        </div>
        <button class="btn btn-primary btn-loading" type="submit">Guardar</button>
    </div>
</form>
@stop