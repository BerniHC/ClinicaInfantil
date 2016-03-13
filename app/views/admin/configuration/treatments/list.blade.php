@section('content')
@include('layouts.configtabs', array('tab' => 'treatments'))
<br/>
@include('layouts.alerts')
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a class="btn btn-primary btn-sm pull-right" href="{{ URL::route('treatment-add') }}">
                    <i class="fa fa-plus"></i> Agregar
                </a>
                <h3 class="panel-title">Tratamientos</h3>
            </div>
            <table class="table table-striped table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!count($treatments))
                    <tr>
                        <td class="text-center" colspan="3">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($treatments as $t)
                    <tr>
                        <td>{{ $t->description }}</td>
                        <td>{{ $t->category->description }}</td>
                        <td>₡{{ $t->price }}</td>
                        <td class="actions hidden-xs">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('treatment-edit', $t->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('treatment-delete', $t->id) }}" title="Eliminar">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="search">Descripcion</th>
                        <th class="search">Categoría</th>
                        <th class="search">Precio</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </tfoot>
            </table>
        </div><!-- end panel -->
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a class="btn btn-primary btn-sm pull-right" href="{{ URL::route('category-add') }}">
                    <i class="fa fa-plus"></i> Agregar
                </a>
                <h3 class="panel-title">Categorías</h3>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Color</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!count($categories))
                    <tr>
                        <td class="text-center" colspan="100">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($categories as $c)
                    <tr>
                        <td>{{ $c->description }}</td>
                        <td>
                            <span class="label label-default" style="background: {{ $c->color }}">
                                {{ $c->color }}
                            </span>
                        </td>
                        <td class="actions hidden-xs">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('category-edit', $c->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('category-delete', $c->id) }}" title="Eliminar">
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