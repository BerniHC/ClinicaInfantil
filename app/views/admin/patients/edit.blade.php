@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        <button class="btn btn-primary btn-loading" type="submit">Guardar</button>
        <br/><br/>
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-xs-12 col-md-6">        
        <div class="form-group{{ $errors->has('document_type') ? 'has-error' : '' }}">
            <label for="document_type" class="control-label">Tipo de Documento *</label>
            {{ Form::select('document_type', $document_types, $patient->person->document_type_id, array('class' => 'form-control')) }}
            @if( $errors->has('document_type') )
            <span class="help-block">{{ $errors->get('document_type')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('document_value') ? 'has-error' : '' }}">
            <label for="document_value" class="control-label">Número de Documento *</label>
            {{ Form::text('document_value', $patient->person->document_value, array('class' => 'form-control', 'maxlength' => '30')) }}
            @if( $errors->has('document_value') )
            <span class="help-block">{{ $errors->get('document_value')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
            <label for="firstname" class="control-label">Nombre *</label>
            {{ Form::text('firstname', $patient->person->firstname, array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('firstname') )
            <span class="help-block">{{ $errors->get('firstname')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('middlename') ? 'has-error' : '' }}">
            <label for="middlename" class="control-label">Primer Apellido</label>
            {{ Form::text('middlename', $patient->person->middlename, array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('middlename') )
            <span class="help-block">{{ $errors->get('middlename')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
            <label for="lastname" class="control-label">Segundo Apellido</label>
            {{ Form::text('lastname', $patient->person->lastname, array('class' => 'form-control', 'maxlength' => '50')) }}
            @if( $errors->has('lastname') )
            <span class="help-block">{{ $errors->get('lastname')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('birthdate') ? 'has-error' : '' }}">
            <label for="birthdate" class="control-label">Fecha de Nacimiento *</label>
            <div class='input-group date' data-role="datepicker">
                {{ Form::text('birthdate', date('d/m/Y', strtotime($patient->person->birthdate)), array('class' => 'form-control', 'data-mask' => '99/99/9999', 'placeholder' => '30/12/1999')) }}
                <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                </span>
            </div>
            @if( $errors->has('birthdate') )
            <span class="help-block">{{ $errors->get('birthdate')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            <label for="gender" class="control-label">Género *</label>
            @foreach($genders as $index=>$gender)
            <label class="radio-inline">
                {{ Form::radio('gender', $gender->id, $gender->id == $patient->person->gender_id) }} {{ $gender->description }}
            </label>
            @endforeach
            @if( $errors->has('gender') )
            <span class="help-block">{{ $errors->get('gender')[0] }}</span>
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-md-6">                
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="firstname" class="control-label">Correo Electrónico</label>
            {{ Form::email('email', $patient->email, array('class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'example@domain.com')) }}
            @if( $errors->has('email') )
            <span class="help-block">{{ $errors->get('email')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('telephone') ? 'has-error' : '' }}">
            <label for="telephone" class="control-label">Teléfono</label>
            <div class="input-group">
                <span class="input-group-addon">+506</span>
                {{ Form::text('telephone', '', array('class' => 'form-control', 'maxlength' => '15', 'placeholder' => '99999999')) }}
            </div>
            @if( $errors->has('telephone') )
            <span class="help-block">{{ $errors->get('telephone')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('father') ? 'has-error' : '' }}">
            <label for="father" class="control-label">Nombre del Padre</label>
            {{ Form::text('father', $patient->father, array('class' => 'form-control', 'maxlength' => '100')) }}
            @if( $errors->has('father') )
            <span class="help-block">{{ $errors->get('father')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('mother') ? 'has-error' : '' }}">
            <label for="mother" class="control-label">Nombre de la Madre</label>
            {{ Form::text('mother', $patient->mother, array('class' => 'form-control', 'maxlength' => '100')) }}
            @if( $errors->has('mother') )
            <span class="help-block">{{ $errors->get('mother')[0] }}</span> 
            @endif
        </div>   
        <div class="form-group {{ $errors->has('school') ? 'has-error' : '' }}">
            <label for="school" class="control-label">Institución Educativa</label>
            {{ Form::text('school', $patient->school, array('class' => 'form-control', 'maxlength' => '100')) }}
            @if( $errors->has('school') )
            <span class="help-block">{{ $errors->get('school')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('observation') ? 'has-error' : '' }}">
            <label for="observation" class="control-label">Observacion</label>
            {{ Form::textarea('observation', $patient->observation, array('class' => 'form-control', 'rows' => 3)) }}
            @if( $errors->has('observation') )
            <span class="help-block">{{ $errors->get('observation')[0] }}</span>
            @endif
        </div>
    </div>     
</form>
@stop
