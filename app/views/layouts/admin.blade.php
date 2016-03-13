<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Berni Hidalgo - A93111">
        <meta name="author" content="Keneth Murillo - A84451">
        <meta name="description" content="{{ Setting::get('website.description') }}">
        <meta name="keywords" content="{{ Setting::get('website.keywords') }}">

		<title>{{ Setting::get('website.name') }} | {{ $title }}</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('favicon.ico') }}"/>
        
        <!-- Styles-->
        {{ HTML::style('styles/admin-layout.css') }}

        @section('styles')
        @show
	</head>
	<body id="backend">
        <!-- Navmenu -->
        <aside id="navmenu" class="navmenu navmenu-inverse navmenu-fixed-left offcanvas-sm">
            <a class="navmenu-brand visible-md visible-lg" href="{{ URL::route('admin-panel') }}">
                <p>{{ Setting::get('website.name') }}</p>
                <p>{{ Setting::get('website.slogan') }}</p>
            </a>
            @if(!Auth::check())
            <div class="col-xs-12 logo">
                <img class="img-responsive" src="{{ URL::asset('images/tooth.png') }}" alt="{{ Setting::get('website.name') }}"/>
            </div>
            @else
            <ul class="nav navmenu-nav">
                <li><a href="{{ URL::route('dashboard') }}"><i class="fa fa-dashboard"></i> Escritorio</a></li>
                @if(Auth::user()->can("view-calendar"))
                <li><a href="{{ URL::route('calendar') }}"><i class="fa fa-calendar"></i> Calendario</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-appointments,edit-appointments,view-appointments,delete-appointments"))
                <li><a href="{{ URL::route('appointment-list') }}"><i class="fa fa-book"></i> Citas</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-events,edit-events,view-events,delete-events"))
                <li><a href="{{ URL::route('event-list') }}"><i class="fa fa-bell"></i> Eventos</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-patients,edit-patients,view-patients,delete-patients"))
                <li><a href="{{ URL::route('patient-list') }}"><i class="fa fa-users"></i> Pacientes</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-users,edit-users,view-users,delete-users"))
                <li><a href="{{ URL::route('user-list') }}"><i class="fa fa-user-md"></i> Usuarios</a></li>
                @endif
                @if(Auth::user()->ability(NULL, "add-expedients,edit-expedients,view-expedients,delete-expedients"))
                <li><a href="{{ URL::route('expedient-list') }}"><i class="fa fa-folder"></i> Expedientes</a></li>
                @endif
            </ul>
            @endif
        </aside>
        <!-- Navbar -->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#navmenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('/') }}">{{ Setting::get('website.name') }}</a>
        </div>
        <!-- Container -->
        <div class="container">
            <div class="row">
                <section class="col-xs-12">
                    <div class="page-header">
                        @if(Auth::check())
                        <div class="btn-group pull-right">
                            <div class="btn-group">
                                <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-user"></i> {{ Auth::user()->person->partialname() }}
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ URL::route('profile') }}">Mi Cuenta</a></li>
                                    <li><a href="{{ URL::route('change-password') }}">Cambiar Contraseña</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{ URL::route('logout') }}">Cerrar Sesión</a></li>
                                </ul>
                            </div>
                            @if(Auth::user()->can("config-system"))
                            <a href="{{ URL::route('config-website') }}" class="btn btn-default" title="Configuración">
                                <i class="fa fa-gear"></i>
                            </a>
                            @endif
                        </div>
                        @endif
                        <h1 class="nowrap">{{ $title }}</h1>
                    </div>
                    @yield('content')
                </section>
            </div>
            <div class="push"></div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            <a href="{{ URL::to('/') }}">{{ Setting::get('website.name') }}</a> {{ date('Y') }}. Todos los derechos reservados.
        </footer>
    
        <!-- Scripts -->
        {{ HTML::script('scripts/raphael.min.js') }}
        {{ HTML::script('scripts/jquery.min.js') }}
        {{ HTML::script('scripts/moment.min.js') }}
        
        {{ HTML::script('scripts/bootstrap.min.js') }}
        {{ HTML::script('scripts/jasny-bootstrap.min.js') }}

        {{ HTML::script('scripts/components.min.js') }}
        {{ HTML::script('scripts/common.js') }}
        
        {{ HTML::script('scripts/knockout.min.js') }}
        {{ HTML::script('scripts/jquery.svg.min.js') }}
        {{ HTML::script('scripts/jquery.svggraph.min.js') }}
        {{ HTML::script('scripts/odontogram.js') }}

        @section('scripts')
        @show
	</body>
</html>



