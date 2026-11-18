@extends('adminlte::page')

@section('title', 'Editar categoría')

@section('content_header')
    <h3 class="mb-0">Editar categoría</h3>
@stop


@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <!-- Formulario para editar categoría -->
                    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nombre">Nombre de la categoría:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $categoria->nombre }}" required>
                            <label for="descripcion">Descripción:</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" value="{{ $categoria->descripcion }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Actualizar Categoría</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop