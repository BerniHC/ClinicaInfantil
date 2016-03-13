<?php
    $year = date('Y', strtotime($appointment->schedule->start_datetime));
    $month = date('m', strtotime($appointment->schedule->start_datetime));
    $day = date('d', strtotime($appointment->schedule->start_datetime));
?>
@section('content')
@if(!$appointment->trashed())
<div class="btn-group">
    <a class="btn btn-primary" href="{{ URL::route('appointment-edit', $appointment->id) }}">Editar</a>
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            Estado <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            @foreach($status as $s)
            <li class="{{ $appointment->status_id == $s->id ? 'active' : '' }}"><a href="{{ URL::route('appointment-status', array($appointment->id, $s->id)) }}">{{ $s->description }}</a></li>
            @endforeach
        </ul>
    </div>
    <a class="btn btn-default confirm-action" href="{{ URL::route('appointment-delete', $appointment->id) }}">Eliminar</a>
</div>
<a class="btn btn-default" href="{{ URL::route('calendar', array($year, $month, $day)) }}">Ver en el calendario</a>
<br/><br/>
@endif
@include('layouts.alerts')
<div class="row">
    <div class="col-md-6">
        <h4>Datos de la Cita</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th style="width: 170px">Doctor</th>
                    <td>
                        @if($appointment->doctor)
                        <a href="{{ URL::action('user-view', array('id' => $appointment->doctor_id )) }}">
                            {{ $appointment->doctor->person->fullname() }}
                        </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th style="width: 170px">Categoría</th>
                    <td>
                        <span class="label label-default" style="background: {{ $appointment->category->color }}">
                            {{ $appointment->category->description }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td>{{ date('d F, Y', strtotime($appointment->schedule->start_datetime)) }}</td>
                </tr>
                <tr>
                    <th>Hora</th>
                    <td>{{ date('h:i a', strtotime($appointment->schedule->start_datetime)) }}</td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td>{{ $appointment->status->description }}</td>
                </tr>
                <tr>
                    <th>Acompañante</th>
                    <td>{{ $appointment->escort }}</td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td>{{ $appointment->observation }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @if($appointment->patient)
    <div class="col-md-6">
        <h4> Datos del Paciente</h4>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>{{ $appointment->patient->person->document->description }}</th>
                    <td>{{ $appointment->patient->person->document_value }}</td>
                </tr>
                <tr>
                    <th style="width: 170px">Nombre</th>
                    <td>
                        <a href="{{ Url::action('patient-view', array('id' => $appointment->patient->person->id )) }}">
                            {{ $appointment->patient->person->fullname() }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Correo Electrónico</th>
                    <td><a href="mailto:{{ $appointment->patient->email }}">{{ $appointment->patient->email }}</a></td>
                </tr>
                <tr>
                    <th>Género</th>
                    <td>{{ $appointment->patient->person->gender->description }}</td>
                </tr>
                <tr>
                    <th>Edad</th>
                    <td>{{ $appointment->patient->person->age() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
</div>
@stop