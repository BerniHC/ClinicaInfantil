@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email" class="control-label">Correo Electrónico *</label> 
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>             
                {{ Form::text('email', '', array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'email@domain.com')) }}
            </div>
            @if( $errors->has('email') )
            <span class="help-block">{{ $errors->get('email')[0] }}</span>
            @endif
        </div>
        <button class="btn btn-primary btn-loading" type="submit">Agregar</button>
    </div><!-- End Col -->
</form>
@stop