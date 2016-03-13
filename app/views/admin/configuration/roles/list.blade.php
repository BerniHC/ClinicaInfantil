@section('content')
@include('layouts.configtabs', array('tab' => 'roles'))
<br/>
@include('layouts.alerts')
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a class="btn btn-primary btn-sm pull-right" href="{{ URL::route('role-add') }}">
                    <i class="fa fa-plus"></i> Agregar
                </a>
                <h3 class="panel-title">Roles</h3>
            </div>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Usuarios</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $r)
                    <tr>
                        <td>{{ $r->name }}</td>
                        <td class="col-xs">{{ $r->users->count() }}</td>
                        <td class="actions hidden-xs">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('role-edit', $r->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('role-delete', $r->id) }}" title="Eliminar">
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