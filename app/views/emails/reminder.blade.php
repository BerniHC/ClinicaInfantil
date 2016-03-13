@extends('layouts.email')
@section('content')
<h2>Recordatorio cita dental</h2>
<br/>
Estimado(a) {{ $patient }},<br/>
Se le recuerda que usted tiene una cita programada a las {{ $time }}, del día {{ $date }}, 
en la clínica dental {{ Setting::get('website.name') }}. Se le solicita por favor confirmar 
su asistencia a los teléfonos:
<br/>
<ul>
    @foreach(Setting::get('contact.telephones') as $telephone)
    <li>+506 {{ $telephone }}</li>
    @endforeach
</ul>
Para mas información, sobre su cita o cualquier duda, visite 
<a href="{{ URL::route('contact') }}">{{ URL::route('contact') }}</a>
<br/><br/>
@stop