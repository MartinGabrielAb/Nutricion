@extends('layouts.plantilla')
@section('contenido')

<div class="content-wrapper">
<div class="container">
    <div class="row justify-content-center ">
        <div class="col-md-8 mt-4">
            <div class="card">
                <div class="card-header">{{ __('Perfil de usuario') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif   
                    <p>Nombre: {{$user->name}}</p>
                    <p>Mail: {{$user->email}}</p>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

@endsection


