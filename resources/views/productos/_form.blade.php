@csrf
@if($errors->any())
    <div class="alert alert-danger" role="alert">Revisa los campos indicados antes de guardar.</div>
@endif
@if($categorias->isEmpty())
    <div class="alert alert-warning" role="alert">Primero debes <a href="{{ route('categorias.create') }}">crear una categoría</a> para poder guardar productos.</div>
@endif
<div class="mb-3">
    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
    <input id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $producto->nombre ?? '') }}" maxlength="255" required>
    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción</label>
    <textarea id="descripcion" name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="4" maxlength="5000">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
    @error('descripcion')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="precio" class="form-label">Precio <span class="text-danger">*</span></label>
        <input type="number" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio', $producto->precio ?? '') }}" min="0" max="99999999.99" step="0.01" required>
        @error('precio')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
        <input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $producto->stock ?? 0) }}" min="0" max="2147483647" step="1" required>
        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<div class="mb-4">
    <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
    <select id="categoria_id" name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" required>
        <option value="">Selecciona una categoría</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" @selected((string) old('categoria_id', $producto->categoria_id ?? '') === (string) $categoria->id)>{{ $categoria->nombre }}</option>
        @endforeach
    </select>
    @error('categoria_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary" @disabled($categorias->isEmpty())>{{ $submitLabel }}</button>
    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
