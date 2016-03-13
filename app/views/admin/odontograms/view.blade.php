@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.getJSON('{{ URL::route("odontogram-treatments", $odontogram->id) }}', function (data) {
            $.each(data, function (key, val) {
                agregarTratamiento(val.piece, val.treatment_id);
            });

            renderSvg();
        });
    });
</script>
@stop
@section('content')
<div class="btn-group">
    @if(!$odontogram->trashed())
    <a class="btn btn-primary" href="{{ URL::route('odontogram-edit', $odontogram->id) }}">Editar</a>
    @else
    <a class="btn btn-default" href="#">Restaurar</a>
    @endif
</div>
<br/><br/>
@include('layouts.alerts')
<div class="row">
    <!-- Odontogram Data -->
    <div class="col-md-6">
        <h4>Datos del Odontograma</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width: 170px"><strong>Descripción</strong></td>
                    <td>{{ $odontogram->description }}</td>
                </tr>
                <tr>
                    <th><strong>Fecha</strong></th>
                    <td>{{ date('d/m/Y h:i a', strtotime($odontogram->created_at)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h4>Observación</h4>
        <table class="table">
            <tbody>
                <tr>
                    <td>{{ $odontogram->observation }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row hidden-xs">
    <!-- Odontogram -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-12">
                <h4>Odontograma</h4>
                <div id="odontogram-wrapper" class="center-block" style="width: 620px;">
                    <div id="odontogram"></div>
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
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tratamientos</h3>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Pieza</th>
                        <th>Tratamiento</th>
                        <th class="hidden-xs">Observacion</th>
                        <th>Fecha</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @if($odontogram->treatments->count() == 0)
                    <tr>
                        <td colspan="5" class="text-center">No se dispone de ningun dato para esta tabla</td>
                    </tr>
                    @endif
                    @foreach($odontogram->treatments as $t)
                    <tr>
                        <td class="col-xs">{{ $t->pivot->piece }}</td>
                        <td class="col-md">{{ $t->description }}</td>
                        <td class="col-lg hidden-xs">{{ $t->pivot->observation }}</td>
                        <td class="col-sm">{{ date('d/m/Y h:i a', strtotime($t->pivot->created_at)) }}</td>
                        <td class="actions hidden-xs rowlink-skip">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="#" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs" href="#" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop