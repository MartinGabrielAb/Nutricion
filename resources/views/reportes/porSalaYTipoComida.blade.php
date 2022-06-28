@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center ">
            <div class="col">
                    <reportes-component :id= "{{$relevamiento->RelevamientoId}}" ></reportes-component>
            </div>
        </div>
    </div>
</div>
@endsection