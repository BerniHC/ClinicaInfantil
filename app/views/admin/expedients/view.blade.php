@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        renderSvg();
        
        $(".dropper-files").dropper({
            maxQueue: 4,
            maxSize: 52428800, // 50 MB
            action: '{{ URL::route("archive-upload", $expedient->id) }}',
            postData: { '_token': '{{ csrf_token() }}' },
            postKey: 'file'
        }).on("start.dropper", onStartDropper)
          .on("fileStart.dropper", onStartUpload)
          .on("fileProgress.dropper", onProgressDropper)
          .on("fileComplete.dropper", onCompleteDropper)
          .on("fileError.dropper", onErrorDropper);
          
        $(".dropper-images").dropper({
            maxQueue: 4,
            maxSize: 5242880, // 5 MB
            action: '{{ URL::route("image-upload", $expedient->id) }}',
            postData: { '_token': '{{ csrf_token() }}' },
            postKey: 'image'
        }).on("start.dropper", onStartDropper)
          .on("fileStart.dropper", onStartUpload)
          .on("fileProgress.dropper", onProgressDropper)
          .on("fileComplete.dropper", onCompleteDropper)
          .on("fileError.dropper", onErrorDropper);

        $.getJSON('{{ URL::route("expedient-treatments", $expedient->id) }}', function (data) {
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
    @if(!$expedient->trashed())
    <a class="btn btn-primary" href="{{ URL::route('expedient-edit', $expedient->id) }}">Editar</a>
    <a class="btn btn-default confirm-action" href="{{ URL::route('expedient-delete', $expedient->id) }}">Eliminar</a>
    @else
    <a class="btn btn-default confirm-action" href="{{ URL::route('expedient-restore', $expedient->id) }}">Restaurar</a>
    @endif
</div>
<br/><br/>
@include('layouts.alerts')
<div class="row">
    <!-- Patient Data -->
    <div class="col-md-6">
        <h4>Datos del Paciente</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td style="width: 170px"><strong>{{ $expedient->patient->person->document->description }}</strong></td>
                    <td>{{ $expedient->patient->person->document_value }}</td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <td>
                        <a href="{{ URL::action('patient-view', array('id' => $expedient->patient->id )) }}">
                            {{ $expedient->patient->person->fullname() }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><strong>Género</strong></td>
                    <td>{{ $expedient->patient->person->gender->description }}</td>
                </tr>
                <tr>
                    <td><strong>Edad</strong></td>
                    <td>{{ $expedient->patient->person->age() }}</td>
                </tr>
                <tr>
                    <td><strong>Referido por</strong></td>
                    <td>{{ $expedient->refered_by }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Clinical History -->
    <div class="col-md-6">
        <h4>Antecedentes Clínicos</h4>
        <table class="table table-striped">
            <tbody>
                @if($expedient->antecedents->count() == 0)
                <tr>
                    <td colspan="2" class="text-center">No se dispone de ningun dato para esta tabla</td>
                </tr>
                @endif
                @foreach($expedient->antecedents as $h)
                <tr>
                    <td style="width: 170px"><strong>{{ $h->description }}</strong></td>
                    <td>{{ $h->pivot->observation }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row hidden-xs">
    <!-- Odontogram -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-xs-12">
                <h4>Odontograma General</h4>
                <div id="odontogram-wrapper" class="center-block" style="width: 620px;">
                    <div id="odontogram" data-type="by-expedient" data-expedient="{{ $expedient->id }}"></div>
                </div>
            </div>
            <div class="col-xs-12 text-center">
                <h5>SIMBOLOGÍA</h5>
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
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                @if(!$expedient->trashed())
                <a class="btn btn-primary btn-sm pull-right" href="{{ URL::route('odontogram-add', array($expedient->id)) }}">
                    <i class="fa fa-plus"></i> Agregar
                </a>
                @endif
                <h3 class="panel-title">Odontogramas</h3>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        @if(!$expedient->trashed())
                        <th class="actions hidden-xs">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @if($expedient->odontograms->count() == 0)
                    <tr>
                        <td colspan="3" class="text-center">No se dispone de ningun dato para esta tabla</td>
                    </tr>
                    @endif
                    @foreach($expedient->odontograms as $o)
                    <tr>
                        <td class="col-md">{{ $o->description }}</td>
                        <td class="col-md">{{ date('d/m/Y h:i a', strtotime($o->created_at)) }}</td>
                        @if(!$expedient->trashed())
                        <td class="actions hidden-xs rowlink-skip">
                            <a class="hidden" href="{{ URL::route('odontogram-view', array($o->id)) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('odontogram-edit', $o->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs" href="{{ URL::route('odontogram-delete', $o->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                @if(!$expedient->trashed())
                <a class="btn btn-primary btn-sm pull-right" href="#">
                    <i class="fa fa-plus"></i> Agregar
                </a>
                @endif
                <h3 class="panel-title">Citas</h3>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Categoría</th>
                        @if(!$expedient->trashed())
                        <th class="actions hidden-xs">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @if($expedient->patient->appointments->count() == 0)
                    <tr>
                        <td colspan="3" class="text-center">No se dispone de ningun dato para esta tabla</td>
                    </tr>
                    @endif
                    @foreach($expedient->patient->appointments as $a)
                    <?php
                        $year = date('Y', strtotime($a->schedule->start_datetime));
                        $month = date('m', strtotime($a->schedule->start_datetime));
                        $day = date('d', strtotime($a->schedule->start_datetime));
                    ?>
                    <tr>
                        <td class="col-md">{{ date('d/m/Y h:i a', strtotime($a->schedule->start_datetime )) }}</td>
                        <td class="col-md">{{ $a->category->description }}</td>
                        @if(!$expedient->trashed())
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('appointment-view', $a->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('calendar', array($year, $month, $day)) }}" title="Calendario">
                                    <i class="fa fa-calendar"></i>
                                </a>
                                <a class="btn btn-default btn-xs" href="{{ URL::route('appointment-edit', $a->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('appointment-delete', $a->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Archivos</h3>
            </div>
            <div class="panel-body">
                @if(!$expedient->trashed())
                <div class="dropper dropper-files" data-queue="#file-queue" data-list="#file-list"></div>
                <ul id="file-queue" class="dropperlist row">
                    <li class="clearfix"></li>
                </ul>
                <hr/>
                @endif
                <ul id="file-list" class="dropperlist row">
                    @foreach($expedient->archives as $a)
                    <li class="col-xs-6 col-md-3">
                        <a class="close confirm-action" href="{{ URL::route('archive-delete', $a->id) }}" title="Eliminar" >&times;</a>
                        <a class="item" href="{{ URL::route('archive-download', $a->id) }}" title="{{ $a->filename }} - {{ date('d/m/Y h:i a', strtotime($a->created_at)) }}">
                            <i class="fa {{ $a->icon() }} fa-4x"></i>
                            <div class="filename" title="">{{ $a->filename }}</div>
                            <small class="text-muted">{{ date('d/m/Y h:i a', strtotime($a->created_at)) }}</small>
                        </a>
                    </li>
                    @endforeach
                    <li class="clearfix"></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Imágenes</h3>
            </div>
            <div class="panel-body">
                @if(!$expedient->trashed())
                <div class="dropper dropper-images" data-queue="#image-queue" data-list="#image-list"></div>
                <ul id="image-queue" class="dropperlist row">
                    <li class="clearfix"></li>
                </ul>
                <hr/>
                @endif
                <ul id="image-list" class="dropperlist row">
                    @foreach($expedient->images as $i)
                    <li class="col-xs-6 col-md-3">
                        <a class="close confirm-action" href="{{ URL::route('image-delete', $i->id) }}" title="Eliminar" >&times;</a>
                        <a class="item boxer" href="{{ $i->content() }}" title="{{ $i->filename }} - {{ date('d/m/Y h:i a', strtotime($i->created_at)) }}" data-gallery="gallery">
                            <img src="{{ $i->thumb(94, 70) }}" alt="{{ $i->filename }}"/>
                            <small class="text-muted">{{ date('d/m/Y h:i a', strtotime($i->created_at)) }}</small>
                        </a>
                    </li>
                    @endforeach
                    <li class="clearfix"></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="odontogram-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tratamietos aplicados</h4>
            </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Pieza</th>
                            <th>Tratamiento</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>
@stop