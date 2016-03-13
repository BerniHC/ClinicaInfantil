@section('content')
@include('layouts.configtabs', array('tab' => 'metatypes'))
<br/>
@include('layouts.alerts')
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a class="btn btn-primary btn-sm pull-right" href="{{ URL::route('metatype-add') }}">
                    <i class="fa fa-plus"></i> Agregar
                </a>
                <h3 class="panel-title">Metatipos</h3>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Grupo</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!count($metatypes))
                    <tr>
                        <td class="text-center" colspan="3">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($metatypes as $m)
                    <tr>
                        <td>{{ $m->description }}</td>
                        <td>{{ $m->metagroup->description }}</td>
                        <td class="actions hidden-xs">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('metatype-edit', $m->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('metatype-delete', $m->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- end panel -->
    </div>
</div>
@stop