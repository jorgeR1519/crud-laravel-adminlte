@extends('adminlte::page')
@section('title', 'Editar producto')
@section('content_header')
    <h1 class="h3">Editar producto</h1>
@endsection
@section('content')
    <div class="row"><div class="col-lg-8">
        <div class="card card-outline card-primary">
            <div class="card-header"><h2 class="card-title">{{ $producto->nombre }}</h2></div>
            <div class="card-body">
                <form action="{{ route('productos.update', $producto) }}" method="POST">
                    @method('PUT')
                    @include('productos._form', ['submitLabel' => 'Guardar cambios'])
                </form>
            </div>
        </div>
    </div></div>
@endsection
