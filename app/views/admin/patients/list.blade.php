<?php
    $actives = $patients->filter(function($patient) {
        return !$patient->trashed();
    });
    
    $trashed = $patients->filter(function($patient) {
        return $patient->trashed();
    });
?>
@section('content')
<div class="btn-group">
    <a class="btn btn-primary" href="{{ URL::route('patient-add') }}">
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
                <h3 class="panel-title">Pacientes Activos</h3>
            </div>
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th class="visible-xs">Nombre</th>
                        <th class="hidden-xs">Nombre</th>
                        <th class="hidden-xs">Apellidos</th>
                        <th class="hidden-xs hidden-sm">Edad</th>
                        <th class="visible-lg">Género</th>                        
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($actives as $p)
                    <tr>
                        <td class="col-md">{{ $p->person->document_value }}</td>
                        <td class="col-md visible-xs">{{ $p->person->partialname() }}</td>
                        <td class="col-md hidden-xs">{{ $p->person->firstname }}</td>
                        <td class="col-md hidden-xs">{{ $p->person->surnames() }}</td>
                        <td class="col-sm hidden-xs hidden-sm">{{ $p->person->age() }}</td>
                        <td class="col-sm visible-lg">{{ $p->person->gender->description }}</td>                        
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('patient-view', $p->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('patient-edit', $p->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('patient-delete', $p->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Identificación</th>
                        <th class="search visible-xs">Nombre</th>
                        <th class="search hidden-xs">Nombre</th>
                        <th class="search hidden-xs">Apellidos</th>
                        <th class="search hidden-xs hidden-sm">Edad</th>
                        <th class="search visible-lg">Género</th>                        
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
                <h3 class="panel-title">Pacientes Eliminados</h3>
            </div>
            <table class="table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th class="visible-xs">Nombre</th>
                        <th class="hidden-xs">Nombre</th>
                        <th class="hidden-xs">Apellidos</th>
                        <th class="hidden-xs hidden-sm">Edad</th>
                        <th class="visible-lg">Género</th>                        
                        <th class="hidden-xs actions">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($trashed as $p)
                    <tr>
                        <td class="col-md">{{ $p->person->document_value }}</td>
                        <td class="col-md visible-xs">{{ $p->person->partialname() }}</td>
                        <td class="col-md hidden-xs">{{ $p->person->firstname }}</td>
                        <td class="col-md hidden-xs">{{ $p->person->surnames() }}</td>
                        <td class="col-sm hidden-xs hidden-sm">{{ $p->person->age() }}</td>
                        <td class="col-sm visible-lg">{{ $p->person->gender->description }}</td>                        
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('patient-view', $p->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('patient-restore', $p->id) }}" title="Restaurar">
                                    <i class="fa fa-reply"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Identificación</th>
                        <th class="search visible-xs">Nombre</th>
                        <th class="search hidden-xs">Nombre</th>
                        <th class="search hidden-xs">Apellidos</th>
                        <th class="hidden-xs hidden-sm search">Edad</th>
                        <th class="visible-lg search">Género</th>                        
                        <th class="hidden-xs actions">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop
