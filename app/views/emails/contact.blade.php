@extends('layouts.email')
@section('content')
<h2>Mensaje de contacto</h2>
<br/>
Se ha generado el siguiente mensaje de contacto por parte de un usuario:
<br/><br/>
<strong>Usuario:</strong> {{ $name }}<br/>
<strong>Correo electrónico:</strong> {{ $email }}<br/>
<strong>Teléfono:</strong> {{ $telephone }}
<br/><br/>
<strong>Mensaje:</strong><br/>
{{ $msg }}
<br/><br/>
@stop