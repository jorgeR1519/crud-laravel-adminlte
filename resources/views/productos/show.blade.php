@extends('adminlte::page')
@section('title', 'Detalle del producto')
@section('content_header')
    <h1 class="h3">Detalle del producto</h1>
@endsection
@section('content')
    <div class="row"><div class="col-lg-8">
        <div class="card card-outline card-primary">
            <div class="card-header"><h2 class="card-title">{{ $producto->nombre }}</h2></div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">ID</dt><dd class="col-sm-9">{{ $producto->id }}</dd>
                    <dt class="col-sm-3">Descripción</dt><dd class="col-sm-9 text-break" style="white-space: pre-line">{{ $producto->descripcion ?: 'Sin descripción' }}</dd>
                    <dt class="col-sm-3">Categoría</dt><dd class="col-sm-9">{{ $producto->categoria->nombre }}</dd>
                    <dt class="col-sm-3">Precio</dt><dd class="col-sm-9">{{ number_format((float) $producto->precio, 2, ',', '.') }}</dd>
                    <dt class="col-sm-3">Stock</dt><dd class="col-sm-9">{{ $producto->stock }} unidades</dd>
                </dl>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-primary">Editar producto</a>
                <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
            </div>
        </div>
    </div></div>
@endsection
