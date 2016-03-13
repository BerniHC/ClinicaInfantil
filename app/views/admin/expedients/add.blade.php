@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            // Patients
            var patients = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                prefetch: '{{ URL::route("appointment-patients") }}'
            });

            patients.initialize();
            $('[name="patient"]').typeahead(null, {
                name: 'patients',
                displayKey: 'name',
                source: patients.ttAdapter()
            }).bind('typeahead:selected', function (obj, datum, name) {
                $('[name="patient_id"]').val(datum.id);
            });
            
            $('[name="patient"]').keyup(function () {
                $('[name="patient_id"]').val("");
            });
        });
    </script>
@stop
@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('patient_id') ? 'has-error' : '' }}">
            <label for="patient" class="control-label">Paciente *</label>
            {{ Form::text('patient', '', array('class' => 'form-control', 'maxlength' => '50', 'autocomplete' => 'off')) }}
            {{ Form::hidden('patient_id', '') }}
            @if($errors->has('patient_id'))
            <span class="help-block">{{ $errors->get('patient_id')[0] }}</span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('refered_by') ? 'has-error' : '' }}">
            <label for="refered_by" class="control-label">Referido por</label>
            {{ Form::text('refered_by', '', array('class' => 'form-control', 'maxlength' => '50')) }}
            @if($errors->has('refered_by'))
            <span class="help-block">{{ $errors->get('refered_by')[0] }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="ailments" class="control-label">Antecedentes clínicos</label>
            <ul class="list-group">
                @foreach($antecedents as $key => $a)
                <li class="list-group-item">
                    <label>{{ Form::checkbox('antecedents['.$key.']', $a->id, false, array('data-hidden' => '#antecedent-'.$a->id)) }} {{ $a->description }}</label>
                    <input id="antecedent-{{$a->id}}" class="hidden-field form-control" type="text" name="observations[{{$key}}]" value="{{ Input::old('observations.'.$key) }}" maxlength="100" placeholder="Especifique"/>
                </li>
                @endforeach
            </ul>
        </div>
        <button class="btn btn-primary btn-loading" type="submit">Agregar</button>
    </div><!-- End Col -->
</form>
@stop