<?php
    $actives = $users->filter(function($user) {
        return !$user->trashed();
    });
    
    $trashed = $users->filter(function($user) {
        return $user->trashed();
    });
?>
@section('content')
<div class="btn-group">
    <a class="btn btn-primary" href="{{ URL::route('user-add') }}">
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
<!-- Tab Tanes -->
<div class="tab-content">
    <!-- Tab Actives -->
    <div class="tab-pane fade in active" id="actives">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Usuarios Activos</h3>
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
                        <th class="hidden-xs">Rol</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($actives as $u)
                    <tr>
                        <td class="col-md">{{ $u->person->document_value }}</td>
                        <td class="col-md visible-xs">{{ $u->person->partialname() }}</td>
                        <td class="col-md hidden-xs">{{ $u->person->firstname }}</td>
                        <td class="col-md hidden-xs">{{ $u->person->surnames() }}</td>
                        <td class="col-sm hidden-xs hidden-sm">{{ $u->person->age() }}</td>
                        <td class="col-sm visible-lg">{{ $u->person->gender->description }}</td>
                        <td class="col-md hidden-xs">{{ $u->roles()->first()->name }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('user-view', $u->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('user-edit', $u->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('user-delete', $u->id) }}" title="Eliminar">
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
                        <th class="search hidden-xs">Rol</th>
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
                <h3 class="panel-title">Usuarios Eliminados</h3>
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
                        <th class="hidden-xs">Rol</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    @foreach($trashed as $u)
                    <tr>
                        <td class="col-md">{{ $u->person->document_value }}</td>
                        <td class="col-md visible-xs">{{ $u->person->partialname() }}</td>
                        <td class="col-md hidden-xs">{{ $u->person->firstname }}</td>
                        <td class="col-md hidden-xs">{{ $u->person->surnames() }}</td>
                        <td class="col-sm hidden-xs hidden-sm">{{ $u->person->age() }}</td>
                        <td class="col-sm visible-lg">{{ $u->person->gender->description }}</td>
                        <td class="col-md hidden-xs">{{ $u->roles()->first()->name }}</td>
                        <td class="actions rowlink-skip hidden-xs">
                            <a class="hidden" href="{{ URL::route('user-view', $u->id) }}">Ver</a>
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('user-restore', $u->id) }}" title="Restaurar">
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
                        <th class="search hidden-xs hidden-sm">Edad</th>
                        <th class="search visible-lg">Género</th>
                        <th class="search hidden-xs">Rol</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@stop
