@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center ">
            <div class="col">
                    <seleccion-component :id="{{$id}}"></seleccion-component>
            </div>
        </div>
    </div>
</div>
@endsection