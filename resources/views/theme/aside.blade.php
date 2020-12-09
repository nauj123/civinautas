<div class="side-content-wrap">
  <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
    <ul class="navigation-left">
      @auth
     @foreach ($modulos as $m)
     <li class="nav-item">
     <a class="nav-item-hold" href="{{ route($m->url) }}">
          <i class="{{$m->icono}}"></i> 
          <span class="nav-text"> {{$m->nombre_modulo}}</span>
        </a>
    </li>
    @endforeach
    @endauth
     </ul>
  </div>
  <div class="sidebar-overlay"></div>
</div>
