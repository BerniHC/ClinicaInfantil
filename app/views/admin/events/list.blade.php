@section('content')
<div class="btn-group">
    <a class="btn btn-primary" href="{{ URL::route('event-add') }}">
        <i class="fa fa-plus"></i> Nuevo
    </a>
</div>
<br/><br/>
@include('layouts.alerts')
<!-- Nav Tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#actives" role="tab" data-toggle="tab">Próximas ({{ $upcoming->count() }})</a></li>
    <li><a href="#trashed" role="tab" data-toggle="tab">Pasadas ({{ $outgoing->count() }})</a></li>
</ul>
<!-- Tab Panes -->
<div class="tab-content">
    <!-- Tab Actives -->
    <div class="tab-pane fade in active" id="actives">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Eventos Próximos</h3>
            </div>
            <table class="table table-striped table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>Fecha Inicio</th>
                        <th>Asunto</th>
                        <th class="hidden-xs hidden-sm">Duración</th>
                        <th class="hidden-xs">Prioridad</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($upcoming as $e)
                    <?php
                        $year = date('Y', strtotime($e->schedule->start_datetime));
                        $month = date('m', strtotime($e->schedule->start_datetime));
                        $day = date('d', strtotime($e->schedule->start_datetime));
                    ?>
                    <tr>
                        <td class="col-md">{{ date('d/m/Y h:i a', strtotime($e->schedule->start_datetime)) }}</td>
                        <td class="col-md">{{ $e->subject }}</td>
                        <td class="col-md hidden-xs hidden-sm">{{ $e->schedule->duration() }}</td>
                        <td class="col-md hidden-xs">{{ $e->priority->description }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('event-view', $e->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('calendar', array($year, $month, $day)) }}" title="Calendario">
                                    <i class="fa fa-calendar"></i>
                                </a>
                                <a class="btn btn-default btn-xs" href="{{ URL::route('event-edit', $e->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('event-delete', $e->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Fecha Inicio</th>
                        <th class="search">Asunto</th>
                        <th class="search hidden-xs hidden-sm">Duración</th>
                        <th class="search hidden-xs">Prioridad</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Tab Trashed -->
    <div class="tab-pane fade" id="trashed">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Eventos Pasados</h3>
            </div>
            <table class="table table-striped table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>Fecha Inicio</th>
                        <th>Asunto</th>
                        <th class="hidden-xs hidden-sm">Duración</th>
                        <th class="hidden-xs">Prioridad</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($outgoing as $e)
                    <?php
                        $year = date('Y', strtotime($e->schedule->start_datetime));
                        $month = date('m', strtotime($e->schedule->start_datetime));
                        $day = date('d', strtotime($e->schedule->start_datetime));
                    ?>
                    <tr>
                        <td class="col-md">{{ date('d/m/Y h:i a', strtotime($e->schedule->start_datetime)) }}</td>
                        <td class="col-md">{{ $e->subject }}</td>
                        <td class="col-md hidden-xs hidden-sm">{{ $e->schedule->duration() }}</td>
                        <td class="col-md hidden-xs">{{ $e->priority->description }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('event-view', $e->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('calendar', array($year, $month, $day)) }}" title="Calendario">
                                    <i class="fa fa-calendar"></i>
                                </a>
                                <a class="btn btn-default btn-xs" href="{{ URL::route('event-edit', $e->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('event-delete', $e->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Fecha Inicio</th>
                        <th class="search">Asunto</th>
                        <th class="search hidden-xs hidden-sm">Duración</th>
                        <th class="search hidden-xs">Prioridad</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop