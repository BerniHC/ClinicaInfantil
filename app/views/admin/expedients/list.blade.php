<?php
    $actives = $expedients->filter(function($expedient) {
        return !$expedient->trashed();
    });
    
    $trashed = $expedients->filter(function($expedient) {
        return $expedient->trashed();
    });
?>
@section('content')
<div class="btn-group">
    <a class="btn btn-primary" href="{{ URL::route('expedient-add') }}">
        <i class="fa fa-plus"></i> Nuevo
    </a>
</div>
<br/><br/>
@include('layouts.alerts')
<!-- Nav Tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#actives" role="tab" data-toggle="tab">Activos ({{ $actives->count() }})</a></li>
    <li><a href="#trashed" role="tab" data-toggle="tab">Eliminados ({{ $trashed->count() }})</a></li>
</ul>
<!-- Tab Panes -->
<div class="tab-content">
    <!-- Tab Actives -->
    <div class="tab-pane fade in active" id="actives">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Expedientes Activos</h3>
            </div>
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Expediente</th>
                        <th class="hidden-xs hidden-sm">Identificación</th>
                        <th class="visible-xs">Paciente</th>
                        <th class="hidden-xs">Paciente</th>
                        <th class="visible-lg">Edad</th>
                        <th class="hidden-xs">Creado</th>                     
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($actives as $e)
                    <tr>
                        <td class="col-sm">{{ $e->id }}</td>
                        <td class="col-md hidden-xs hidden-sm">{{ $e->patient->person->document_value }}</td>
                        <td class="col-md visible-xs">{{ $e->patient->person->partialname() }}</td>
                        <td class="col-md hidden-xs">{{ $e->patient->person->fullname() }}</td>
                        <td class="col-xs visible-lg">{{ $e->patient->person->age() }}</td>
                        <td class="col-md hidden-xs">{{ date('d/m/Y h:i a', strtotime($e->created_at)) }}</td>
                        <td class="actions hidden-xs rowlink-skip">
                            <a class="hidden" href="{{ URL::route('expedient-view', $e->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('expedient-edit', $e->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('expedient-delete', $e->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Expediente</th>
                        <th class="search hidden-xs hidden-sm">Identificación</th>
                        <th class="search visible-xs">Paciente</th>
                        <th class="search hidden-xs">Paciente</th>
                        <th class="search visible-lg">Edad</th>
                        <th class="search hidden-xs">Creado</th>                      
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
                <h3 class="panel-title">Expedientes Eliminados</h3>
            </div>
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Expediente</th>
                        <th class="hidden-xs hidden-sm">Identificación</th>
                        <th class="visible-xs">Paciente</th>
                        <th class="hidden-xs">Paciente</th>
                        <th class="visible-lg">Edad</th>
                        <th class="hidden-xs">Eliminado</th>                     
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($trashed as $e)
                    <tr>
                        <td class="col-sm">{{ $e->id }}</td>
                        <td class="col-md hidden-xs hidden-sm">{{ $e->patient->person->document_value }}</td>
                        <td class="col-md visible-xs">{{ $e->patient->person->partialname() }}</td>
                        <td class="col-md hidden-xs">{{ $e->patient->person->fullname() }}</td>
                        <td class="col-xs visible-lg">{{ $e->patient->person->age() }}</td>
                        <td class="col-md hidden-xs">{{ date('d/m/Y h:i a', strtotime($e->deleted_at)) }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('expedient-view', $e->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('expedient-restore', $e->id) }}" title="Restaurar">
                                    <i class="fa fa-reply"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Expediente</th>
                        <th class="search hidden-xs hidden-sm">Identificación</th>
                        <th class="search visible-xs">Paciente</th>
                        <th class="search hidden-xs">Paciente</th>
                        <th class="search visible-lg">Edad</th>
                        <th class="search hidden-xs">Eliminado</th>                      
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop