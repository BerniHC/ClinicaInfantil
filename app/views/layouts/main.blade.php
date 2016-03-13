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
        
        <!-- Styles -->
        {{ HTML::style('styles/main-layout.css') }}
        
        @section('styles')
        @show
	</head>
	<body id="frontend">
        <!-- Navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" data-toggle="@if (Request::is('/')){{'navbar'}}@endif">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ URL::to('/') }}">{{ Setting::get('website.name') }}</a>
                </div>
                <div class="collapse navbar-collapse" id="nav-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::route('home') }}">Principal</a></li>
                        <li><a href="{{ URL::route('contact') }}">Contacto</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right hidden-xs">
                        @if(Setting::get('contact.facebook') != null)
                        <li><a href="{{ Setting::get('contact.facebook') }}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                        @endif
                        @if(Setting::get('contact.twitter') != null)
                        <li><a href="{{ Setting::get('contact.twitter') }}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                        @endif
                        @if(Setting::get('contact.google-plus') != null)
                        <li><a href="{{ Setting::get('contact.google-plus') }}" title="Google Plus"><i class="fa fa-google-plus"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @if (Request::is('/'))
        <div class="front">
            <div class="front-content">
                <img class="logo" src="{{ URL::asset('images/logo.png') }}" alt="{{ Setting::get('website.name') }}"/>
                <div>
                    <h2 class="title">Clínica Infantil - Dra. Magda Guerrero</h2>
                    <hr/>
                    <p class="lead">
                        <i class="fa fa-quote-left"></i> 
                        Dele una sonrisa a todos los que conoce y recibirá sonrisas.
                        <i class="fa fa-quote-right"></i>
                    </p>
                    <span>― William Clement Stone</span>
                </div>
                <a class="scroll-link" href="#main-container">
                    <i class="fa fa-angle-double-down fa-4x"></i>
                </a>
            </div>
        </div>
        @endif
        <!-- Container -->
        <div id="main-container" class="container">
            <div class="push"></div>
            @yield('content')
            <div class="push"></div>
        </div>
        <!-- Footer -->
        <footer class="footer">
            CopyRight &copy; {{ date('Y') }}. <a href="{{ URL::to('/') }}">{{ Setting::get('website.name') }}</a>.
        </footer>
        
        <!-- Scripts -->
        {{ HTML::script('scripts/raphael.min.js') }}
        {{ HTML::script('scripts/jquery.min.js') }}
        {{ HTML::script('scripts/moment.min.js') }}

        {{ HTML::script('scripts/bootstrap.min.js') }}
        {{ HTML::script('scripts/jasny-bootstrap.min.js') }}

        {{ HTML::script('scripts/components.min.js') }}
        {{ HTML::script('scripts/common.js') }}

        @section('scripts')
        @show
	</body>
</html>



