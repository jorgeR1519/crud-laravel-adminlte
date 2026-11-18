@extends('adminlte::page')

@section('title', 'Crear Categoría')

@section('content_header')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Crear Categoría</h3></div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <!-- Formulario para crear categoría -->
                    <form action="{{ route('categorias.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre de la categoría:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                            <label for="descripcion">Descripción:</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" required>

                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Crear Categoría</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
