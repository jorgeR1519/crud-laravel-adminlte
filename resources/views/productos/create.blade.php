@extends('adminlte::page')
@section('title', 'Nuevo producto')
@section('content_header')
    <h1 class="h3">Nuevo producto</h1>
@endsection
@section('content')
    <div class="row"><div class="col-lg-8">
        <div class="card card-outline card-primary">
            <div class="card-header"><h2 class="card-title">Información del producto</h2></div>
            <div class="card-body">
                <form action="{{ route('productos.store') }}" method="POST">
                    @include('productos._form', ['submitLabel' => 'Crear producto'])
                </form>
            </div>
        </div>
    </div></div>
@endsection
