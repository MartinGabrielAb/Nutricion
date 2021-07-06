@extends('layouts.plantilla')
@section('contenido')
<div class="content-wrapper">
    <div class="container-fluid mt-3">
        <div class="row justify-content-center ">
            <div class="col">
                    <historial-component :id= "{{$id}}"></historial-component>
            </div>
        </div>
    </div>
</div>
@endsection