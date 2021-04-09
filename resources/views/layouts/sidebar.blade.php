<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{asset('dist/img/logoHSB.png')}}" alt="Hospital San Bernardo Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Hospital San Bernardo</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @hasanyrole('Admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Administración
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{URL::action('SalaController@index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Salas</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{URL::action('UsuarioController@index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
            </ul>
          </li>
          @endhasanyrole
          {{-- ----------------------Despensa------------------ --}}
          @hasanyrole('Admin|Despensa|Nutricion')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Despensa
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{URL::action('AlimentoController@index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alimentos</p>
                </a>
              </li>
            </ul>
          </li>
          @endhasanyrole
          {{-- ----------------------Nutrición------------------ --}}
          @hasanyrole('Admin|Nutricion')
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Nutrición
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{URL::action('ComidaController@index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Comidas</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{URL::action('HistorialController@index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Historial</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{URL::action('MenuController@index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Menú</p>
                  </a>
                </li>
              </ul>
            </li>
          @endhasanyrole
          @hasanyrole('Admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Personas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <!-- <li class="nav-item">
                {{-- <a href="{{URL::action('EmpleadoController@index')}}" class="nav-link"> --}}
                  <i class="far fa-circle nav-icon"></i>
                  <p>Empleados</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{URL::action('PacienteController@index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pacientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{URL::action('ProveedorController@index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>
              <!-- DESCOMENTAR DESPUES DE HACER EL CONTROLADOR DE LOS PROVEEDORES -->
              
            </ul>
          </li>
          @endhasanyrole
                    {{-- ----------------------Relevamiento------------------ --}}
          @hasanyrole('Admin|Nutricion|Relevamiento')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Relevamiento
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{URL::action('RelevamientoController@index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Relevamientos</p>
                </a>
              </li>
            </ul>
          </li>
          @endhasanyrole
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>