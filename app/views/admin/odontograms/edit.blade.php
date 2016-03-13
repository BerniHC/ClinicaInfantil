@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.getJSON('{{ URL::route("odontogram-treatments", array($odontogram->id)) }}', function (data) {
            $.each(data, function (key, val) {
                agregarTratamiento(val.piece, val.treatment_id);
            });

            renderSvg();
        });

    });
</script>
@stop
@section('content')
<form class="row" method="post" >
    {{ Form::token() }}
    <div class="col-xs-12">
        <button class="btn btn-primary btn-loading" type="submit">Guardar</button>
        <br/><br/>
        @include('layouts.alerts', array('alert_info' => true))
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
            <label for="description" class="control-label">Descripción *</label>
            {{ Form::text('description', $odontogram->description, array('class' => 'form-control', 'maxlength' => '50')) }}
            @if($errors->has('description'))
            <span class="help-block">{{ $errors->get('description')[0] }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Fecha</label>
            {{ Form::text('created_at', $odontogram->created_at, array('class' => 'form-control', 'disabled')) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('observation') ? 'has-error' : '' }}">
            <label for="observation" class="control-label">Observación</label>
            {{ Form::textarea('observation', $odontogram->observation, array('class' => 'form-control', 'rows' => '4')) }}
            @if($errors->has('observation'))
            <span class="help-block">{{ $errors->get('observation')[0] }}</span>
            @endif
        </div>
    </div>
    <!-- Odontogram -->
    <div class="col-md-12 hidden-xs">
        <div class="row">
            <div class="col-xs-12">
                <label for="odontogram" class="control-label">Odontograma</label>
            </div>
            <div class="col-xs-12">
                <div id="odontogram-wrapper" class="center-block" style="width: 620px;">
                    <div id="odontogram" data-type="by-treatment"></div>
                </div>  
            </div>
            <div class="col-xs-12 text-center">
                <h5>SIMBOLOGIA</h5>
                <ul class="list-unstyled list-inline">
                    <li><strong>S</strong> - Cara Superior</li>
                    <li><strong>I</strong> - Cara Inferior</li>
                    <li><strong>Z</strong> - Cara Izquierda</li>
                    <li><strong>D</strong> - Cara Derecha</li>
                    <li><strong>C</strong> - Cara Central</li>
                </ul>
                <br/><br/>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <label for="treatments" class="control-label">Tratamientos</label>
        <table id="treatments" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:80px">Pieza</th>
                    <th style="width:250px">Tratamiento</th>
                    <th class="hidden-xs">Observación</th>
                </tr>
            </thead>
            <tbody style="min-height: 30px">
                @if($odontogram->treatments->count() == 0)
                <tr class="no-data">
                    <td class="text-center" colspan="3">Ningún tratamiento aplicado aún</td>
                </tr>
                @endif
                @foreach($odontogram->treatments as $t)
                <tr>
                    <td>
                        <input type="hidden" name="treatments[{{ $t->id }}][piece]" value="{{ $t->pivot->piece }}" />
                        <input type="hidden" name="treatments[{{ $t->id }}][treatment_id]" value="{{ $t->id }}" />
                        <button type="button" class="close pull-left remove-treatment" data-treatment="{{ $t->id }}" style="margin-right:10px" >
                            <span>&times;</span>
                        </button>
                        <strong>{{ $t->pivot->piece }}</strong>
                    </td>
                    <td>
                        {{ $t->description }}
                    </td>
                    <td>
                        {{ $t->pivot->observation }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>
<!-- Modal -->
<div class="modal fade" id="odontogram-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Agregar Tratamiento</h4>
            </div>
            <div class="modal-body">
                {{ Form::hidden('tooth', '') }}
                {{ Form::hidden('face', '') }}
                <div class="form-group">
                    <label for="treatment" class="control-label">Tratamiento *</label>
                    {{ Form::select('treatment', $treatments, '', array('class' => 'form-control', 'data-role' => 'chosen')) }}
                </div>
                <div class="form-group">
                    <label for="observation" class="control-label">Observación</label>
                    {{ Form::textarea('observations', '', array('class' => 'form-control', 'rows' => '3')) }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="add-treatment">Agregar</button>
            </div>
        </div>
    </div>
</div>
@stop