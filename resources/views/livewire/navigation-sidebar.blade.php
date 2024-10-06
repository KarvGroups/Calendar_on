<div>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">

            <li class="nav-item nav-profile">
                <a href="{{ route('profile.show') }}" class="nav-link">
                    <div class="nav-profile-image">
                    <img src="{{asset('/assets/images/faces/face1.jpg')}}" alt="profile" />
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                    </div>
                    <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->apelido }}</span>
                    <span class="text-secondary text-small">{{ Auth::user()->funcion }}</span>
                    </div>
                    <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                </a>
            </li>
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
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#config" aria-expanded="false" aria-controls="icons">
                    <span class="menu-title">Configuração</span>
                    <i class="mdi mdi-contacts menu-icon"></i>
                </a>
                <div class="collapse" id="config">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Empresa</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</div>
