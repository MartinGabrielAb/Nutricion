
@extends('layouts.plantilla')
@section('contenido')
	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Administracion de Menúes</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Menúes</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
              	<div class="row">
                  <div class="col-lg-8" style="height: 5px">
                    <div id="divMensaje" class="alert"> 
                    </div> 
                  </div>
              		<div class="col-lg-4">
              		  <p class="text-right">
                      <button type="button" class="btn btn-sm btn-default" id="btnAgregarMenu" data-toggle="modal" data-target="#modalAgregarMenu">
                        Agregar Menú
                      </button>
                      <button type="button" class="btn btn-sm btn-default" id="btnAgregarParticular" data-toggle="modal" data-target="#modalAgregarParticular">
                        Agregar Particular
                      </button>
              			</p>	
              		</div>
              	</div>
                @include('menues.modal.agregarMenu')                               @include('menues.modal.agregarParticular')  
              	<!--------------TABLA MENUES NORMALES-------------->
                <h4 class="m-0 text-dark">Menúes Normales</h4>
                <div class="row">
                  <div class="col-lg-12">
                    <table id="tableMenues" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                    <!------Cabecera de la tabla------>
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Costo total</th>
                        <th width="10%">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  </div>
                </div>
              <!--------------TABLA MENUES PARTICULARES-------------->
                <hr>
                  <div class="row">
                    <div class="col-lg-3">
                      <h4 class="m-0 text-dark">Menúes Particulares</h4>
                    </div>
                    <div class="col-lg-9">
                      <button class="btn btn-sm btn-default" id="btnMostrar"style="display:none;">Mostrar</button>
                      <button class="btn btn-sm btn-default" id="btnOcultar">Ocultar</button>
                    </div>
                  </div>
                <div id="divParticulares">  
                <div class="row">
                  <div class="col-lg-12">
                    <table id="tableParticulares" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                    <!------Cabecera de la tabla------>
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Costo total</th>
                        <th width="10%">&nbsp;</th>
                      </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div> 
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
      </div><!-- /.container-fluid -->
    </div>

  <!-- /.content-wrapper -->
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/menues/principal.js')}}"></script>
<script type="text/javascript" src="{{asset('js/menues/create.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#btnMostrar").click(function(){
      $("#btnMostrar").hide();
      $("#btnOcultar").show();
      $("#divParticulares").show();
    });
    $("#btnOcultar").click(function(){
      $("#btnMostrar").show();
      $("#btnOcultar").hide();
      $("#divParticulares").hide();
    });
  });

</script>
@endpush

@endsection
