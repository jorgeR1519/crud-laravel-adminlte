@extends('adminlte::page')
@section('title', 'Productos')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div><h1 class="h3 mb-1">Productos</h1><p class="text-body-secondary mb-0">Administra tu catálogo y las existencias de tu inventario.</p></div>
        <a href="{{ route('productos.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Nuevo producto</a>
    </div>
@endsection
@section('content')
    @if(session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif
    <div class="card card-outline card-primary">
        <div class="card-header"><h2 class="card-title">Catálogo de productos</h2><span class="badge text-bg-primary float-end">{{ $productos->total() }} productos</span></div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead><tr><th scope="col">ID</th><th scope="col">Producto</th><th scope="col">Categoría</th><th scope="col" class="text-end">Precio</th><th scope="col">Stock</th><th scope="col" class="text-end">Acciones</th></tr></thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td class="fw-semibold">{{ $producto->nombre }}</td>
                            <td>{{ $producto->categoria->nombre }}</td>
                            <td class="text-end">{{ number_format((float) $producto->precio, 2, ',', '.') }}</td>
                            <td><span class="badge {{ $producto->stock > 0 ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $producto->stock }} unidades</span></td>
                            <td class="text-end text-nowrap">
                                <a class="btn btn-sm btn-outline-secondary" href="{{ route('productos.show', $producto) }}">Ver</a>
                                <a class="btn btn-sm btn-outline-primary" href="{{ route('productos.edit', $producto) }}">Editar</a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Deseas eliminar este producto? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar<span class="visually-hidden"> {{ $producto->nombre }}</span></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-body-secondary"><i class="bi bi-box-seam fs-1 d-block mb-2" aria-hidden="true"></i>Aún no tienes productos. Crea el primero para empezar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($productos->hasPages())
            <div class="card-footer">{{ $productos->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
