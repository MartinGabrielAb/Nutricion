
@extends('layouts.plantilla')
@section('contenido')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php 
              $tipoPaciente = App\TipoPaciente::FindOrFail($menu->TipoPacienteId)
             ?>
            <h1 class="m-0 text-dark">Administracion de Menues : {{$tipoPaciente->TipoPacienteNombre}}</h1>
            <input type="hidden" name="menuId" id="menuId" value="{{$menu->DetalleMenuTipoPacienteId}}">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/menu/{{$menu->MenuId}}">Tipos de paciente</a></li>
              <li class="breadcrumb-item active">Comidas</li>
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
                      <button type="button" class="btn btn-sm btn-default" id="btnAgregar" data-toggle="modal" data-target="#modalAgregar">
                        Agregar Comida
                      </button>
                    </p>  
                  </div>
                </div>
                @include('menues.modal.agregarTipoComida') 
                <!--------------TABLA PRINCIPAL-------------->
                <div class="row table-reponsive">
                  <div class="col-lg-12">
                    <table id="tableComidas" class="table table-sm table-striped table-bordered table-hover display nowrap" style="width:100%" cellspacing="0">
                    <!------Cabecera de la tabla------>
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Tipo de comida</th>
                        <th>Comida</th>
                        <th>Costo Total</th>
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
          <!-- /.col-md-6 -->
        </div>
      </div><!-- /.container-fluid -->
      <hr>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                <!--------------TABLA NUTRIENTES-------------->
                <div class="row table-reponsive">
                  <div class="col-lg-12 ">
                    <table id="tableNutrientes" class="table table-sm table-bordered" cellspacing="0">
                    <!------Cabecera de la tabla------>
                    <thead>
                      <tr>
                        <th><p class="text-xs">&nbsp;</p></th>
                        <th><p class="text-xs"><small>Alimento</small></p></th>
                        <th><p class="text-xs"><small>Cant</small></p></th>
                        <th><p class="text-xs"><small>Hidratos</small></p></th>
                        <th><p class="text-xs"><small>Protidos</small></p></th>
                        <th><p class="text-xs"><small>Grasas</small></p></th>
                        <th><p class="text-xs"><small>KCAL</small></p></th>
                        <th><p class="text-xs"><small>Hierro</small></p></th>
                        <th><p class="text-xs"><small>Calcio</small></p></th>
                        <th><p class="text-xs"><small>Sodio</small></p></th>
                        <th><p class="text-xs"><small>Vit.A</small></p></th>
                        <th><p class="text-xs"><small>Vit.B1</small></p></th>
                        <th><p class="text-xs"><small>Vit.B2</small></p></th>
                        <th><p class="text-xs"><small>Vit.C</small></p></th>
                        <th><p class="text-xs"><small>Niacina</small></p></th>
                        <th><p class="text-xs"><small>Fibra</small></p></th>
                        <th><p class="text-xs"><small>Colest.</small></p></th>
                        <th><p class="text-xs"><small>A.G.SAT.</small></p></th>
                        <th><p class="text-xs"><small>A.G.MON.</small></p></th>
                        <th><p class="text-xs"><small>A.G.POLI.</small></p></th>
                        <th><p class="text-xs"><small>Potasio</small></p></th>
                        <th><p class="text-xs"><small>Fósforo</small></p></th>
                      </tr>
                    </thead>
                    <tbody id="bodyNutrientes">
                    </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
      </div><!-- /.container-fluid -->
    </div>
  </div>

  <!-- /.content-wrapper -->
@push('custom-scripts')
<script type="text/javascript" src="{{asset('js/menues/comidas.js')}}"></script>
<script type="text/javascript" src="{{asset('js/menues/nutrientes.js')}}"></script>

@endpush

@endsection
