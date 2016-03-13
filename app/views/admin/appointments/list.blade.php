@section('content')
<div class="btn-group">
    <a class="btn btn-primary" href="{{ URL::route('appointment-add') }}">
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
                <h3 class="panel-title">Citas Próximas</h3>
            </div>
            <table class="table table-striped table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th class="visible-xs">Paciente</th>
                        <th class="hidden-xs">Paciente</th>
                        <th class="visible-lg">Estado</th>
                        <th class="hidden-xs hidden-sm">Categoría</th>
                        <th class="hidden-xs actions">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($upcoming as $a)
                    <?php
                        $year = date('Y', strtotime($a->schedule->start_datetime));
                        $month = date('m', strtotime($a->schedule->start_datetime));
                        $day = date('d', strtotime($a->schedule->start_datetime));
                    ?>
                    <tr>
                        <td class="col-md">{{ date('d/m/Y h:i a', strtotime($a->schedule->start_datetime)) }}</td>
                        <td class="col-md visible-xs">{{ $a->patient ? $a->patient->person->partialname() : '[Sin asignar]' }}</td>
                        <td class="col-md hidden-xs">{{ $a->patient ? $a->patient->person->fullname() : '[Sin asignar]' }}</td>
                        <td class="col-md visible-lg">{{ $a->status->description }}</td>
                        <td class="col-md hidden-xs hidden-sm">
                            <span class="label label-default" style="background: {{ $a->category->color }}">
                                {{ $a->category->description }}
                            </span>
                        </td>
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
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Fecha</th>
                        <th class="search visible-xs">Paciente</th>
                        <th class="search hidden-xs">Paciente</th>
                        <th class="search visible-lg">Estado</th>
                        <th class="search hidden-xs hidden-sm">Categoría</th>
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
                <h3 class="panel-title">Citas Pasadas</h3>
            </div>
            <table class="table table-striped table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th class="visible-xs">Paciente</th>
                        <th class="hidden-xs">Paciente</th>
                        <th class="visible-lg">Estado</th>
                        <th class="hidden-xs hidden-sm">Categoría</th>
                        <th class="hidden-xs actions">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($outgoing as $a)
                    <?php
                        $year = date('Y', strtotime($a->schedule->start_datetime));
                        $month = date('m', strtotime($a->schedule->start_datetime));
                        $day = date('d', strtotime($a->schedule->start_datetime));
                    ?>
                    <tr>
                        <td class="col-md">{{ date('d/m/Y h:i a', strtotime($a->schedule->start_datetime)) }}</td>
                        <td class="col-md visible-xs">{{ $a->patient->person->partialname() }}</td>
                        <td class="col-md hidden-xs">{{ $a->patient->person->fullname() }}</td>
                        <td class="col-md visible-lg">{{ $a->status->description }}</td>
                        <td class="col-md hidden-xs hidden-sm">
                            <span class="label label-default" style="background: {{ $a->category->color }}">
                                {{ $a->category->description }}
                            </span>
                        </td>
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
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Fecha</th>
                        <th class="search visible-xs">Paciente</th>
                        <th class="search hidden-xs">Paciente</th>
                        <th class="search visible-lg">Estado</th>
                        <th class="search hidden-xs hidden-sm">Categoría</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop