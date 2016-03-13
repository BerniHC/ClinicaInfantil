<ul class="nav nav-tabs" role="tablist">
    <li class="{{ $tab == 'website' ? 'active' : '' }}"><a href="{{ URL::route('config-website') }}" role="tab">Sitio Web</a></li>
    <li class="{{ $tab == 'contact' ? 'active' : '' }}"><a href="{{ URL::route('config-contact') }}" role="tab">Contacto</a></li>
    <li class="{{ $tab == 'agenda' ? 'active' : '' }}"><a href="{{ URL::route('config-agenda') }}" role="tab">Agenda</a></li>
    <li class="hidden-xs {{ $tab == 'roles' ? 'active' : '' }}"><a href="{{ URL::route('role-list') }}" role="tab">Roles</a></li>
    <li class="hidden-xs {{ $tab == 'metatypes' ? 'active' : '' }}"><a href="{{ URL::route('metatype-list') }}" role="tab">Metatipos</a></li>
    <li class="hidden-xs {{ $tab == 'treatments' ? 'active' : '' }}"><a href="{{ URL::route('treatment-list') }}" role="tab">Tratamientos</a></li>
    <li class="hidden-xs {{ $tab == 'antecedents' ? 'active' : '' }}"><a href="{{ URL::route('antecedent-list') }}" role="tab">Antecedentes</a></li>
</ul>
