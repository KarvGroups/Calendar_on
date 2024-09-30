<div>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">

          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
          @if(Auth::user()->function == 0)

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Configurações</span>
                <i class="menu-arrow"></i>
                <i class="fa fa-cogs"></i>
                </a>
                <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('empresas') }}">Empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('empresas.create') }}">Criar Empresas</a>
                    </li>
                </ul>
                </div>
            </li>
          @endif
            {{-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">Icons</span>
                <i class="mdi mdi-contacts menu-icon"></i>
                </a>
                <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                    <a class="nav-link" href="pages/icons/font-awesome.html">Font Awesome</a>
                    </li>
                </ul>
                </div>
            </li> --}}
        </ul>
    </nav>
</div>
