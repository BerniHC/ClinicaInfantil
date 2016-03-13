@section('content')
<div class="well text-justify">
    <p class="lead">
        {{ Setting::get('website.description') }}
    </p>
</div>
<div class="row">
    <div class="col-xs-12 col-md-4">
        <div class="panel panel-default">
            <img class="img-responsive" src="{{ URL::asset('images/girl.jpg') }}" alt="Niña"/>
        </div>
        <p class="text-justify">
            Ofrecemos tratamientos para niños desde muy temprana edad, enseñándoles desde pequeños técnicas de cepillado 
            y de higiene dental, de tal manera que se irán familiarizando con el medio y los instrumentos dentales. 
        </p>
        <br/><br/>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="panel panel-default">
            <img class="img-responsive" src="{{ URL::asset('images/dentist.jpg') }}" alt="niña"/>
        </div>
        <p class="text-justify">
            El equipo de dentistas, facultativos y profesionales de nuestra clínica dental, bajo la dirección médica de 
            la Dra. Magda Guerrero, se caracteriza por ofrecer un trato personalizado y familiar a todos nuestros pacientes.
        </p>
        <br/><br/>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="panel panel-default">
            <img class="img-responsive" src="{{ URL::asset('images/family.jpg') }}" alt="Familia"/>
        </div>
        <p class="text-justify">
            Porque sabemos que la salud dental es parte esencial de una buena calidad de vida, le ofrecemos calidad humana y 
            profesional en el cuidado de la salud bucal de toda su familia.
        </p>
        <br/><br/>
    </div>
</div>
@stop