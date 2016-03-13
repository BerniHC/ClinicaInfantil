@section('content')
@include('layouts.configtabs', array('tab' => 'antecedents'))
<br/>
@include('layouts.alerts')
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a class="btn btn-primary btn-sm pull-right" href="{{ URL::route('antecedent-add') }}"> 
                    <i class="fa fa-plus"></i> Agregar
                </a>
                <h3 class="panel-title">Antecedentes</h3>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Pacientes</th>
                        <th class="actions hidden-xs">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!count($antecedents))
                    <tr>
                        <td class="text-center" colspan="3">Ningún dato disponible en esta tabla.</td>
                    </tr>
                    @endif
                    @foreach($antecedents as $a)
                    <tr>
                        <td>{{ $a->description }}</td>
                        <td>{{ $a->expedients->count() }}</td>
                        <td class="actions hidden-xs">
                            <div class="btn-group">
                                <a class="btn btn-default btn-xs" href="{{ URL::route('antecedent-edit', $a->id) }}" title="Editar">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-default btn-xs confirm-action" href="{{ URL::route('antecedent-delete', $a->id) }}" title="Eliminar">
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