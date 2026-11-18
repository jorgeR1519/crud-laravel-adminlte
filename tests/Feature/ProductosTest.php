<?php

use Database\Factories\CategoriaFactory;
use Database\Factories\ProductoFactory;

beforeEach(function () {
    $this->withoutVite();
});

test('muestra el listado vacío y permite abrir el formulario sin categorías', function () {
    $this->get(route('productos.index'))->assertOk()->assertSee('Aún no tienes productos');
    $this->get(route('productos.create'))->assertOk()->assertSee('crear una categoría');
});

test('muestra los productos y su categoría con el contenido escapado', function () {
    $producto = ProductoFactory::new()->create(['nombre' => '<script>alert(1)</script>']);

    $this->get(route('productos.index'))->assertOk()->assertSee($producto->nombre)->assertDontSee($producto->nombre, false);
    $this->get(route('productos.show', $producto))->assertOk()->assertSee($producto->categoria->nombre);
    $this->get(route('productos.edit', $producto))->assertOk()->assertSee($producto->nombre);
});

test('crea un producto con una categoría existente', function () {
    $categoria = CategoriaFactory::new()->create();
    $data = ['nombre' => 'Teclado', 'descripcion' => null, 'precio' => '15000.50', 'stock' => 0, 'categoria_id' => $categoria->id];

    $this->post(route('productos.store'), $data)->assertRedirect(route('productos.index'))->assertSessionHas('success');

    $this->assertDatabaseHas('productos', $data);
});

test('actualiza los datos y la categoría del producto', function () {
    $producto = ProductoFactory::new()->create();
    $categoria = CategoriaFactory::new()->create();
    $data = ['nombre' => 'Teclado actualizado', 'descripcion' => 'Nuevo modelo', 'precio' => '20000.75', 'stock' => 5, 'categoria_id' => $categoria->id];

    $this->put(route('productos.update', $producto), $data)->assertRedirect(route('productos.index'))->assertSessionHas('success');

    $this->assertDatabaseHas('productos', ['id' => $producto->id, ...$data]);
});

test('rechaza datos inválidos sin crear o modificar productos', function (string $campo, mixed $valor) {
    $producto = ProductoFactory::new()->create();
    $data = ['nombre' => 'Teclado', 'descripcion' => null, 'precio' => '15000.50', 'stock' => 2, 'categoria_id' => $producto->categoria_id];
    $data[$campo] = $valor;

    $this->post(route('productos.store'), $data)->assertSessionHasErrors($campo);
    $this->put(route('productos.update', $producto), $data)->assertSessionHasErrors($campo);

    $this->assertDatabaseCount('productos', 1);
    $this->assertDatabaseHas('productos', ['id' => $producto->id, 'nombre' => $producto->nombre, 'precio' => $producto->precio, 'stock' => $producto->stock]);
})->with([
    'nombre obligatorio' => ['nombre', ''],
    'nombre demasiado largo' => ['nombre', str_repeat('a', 256)],
    'nombre inválido' => ['nombre', ['texto']],
    'descripción demasiado larga' => ['descripcion', str_repeat('a', 5001)],
    'precio obligatorio' => ['precio', ''],
    'precio no numérico' => ['precio', 'gratis'],
    'precio negativo' => ['precio', '-1'],
    'precio fuera de rango' => ['precio', '100000000'],
    'precio con más de dos decimales' => ['precio', '10.123'],
    'stock obligatorio' => ['stock', ''],
    'stock negativo' => ['stock', -1],
    'stock fraccionario' => ['stock', 1.5],
    'stock fuera de rango' => ['stock', '2147483648'],
    'categoría obligatoria' => ['categoria_id', ''],
    'categoría inexistente' => ['categoria_id', 999999],
]);

test('elimina el producto sin eliminar su categoría', function () {
    $producto = ProductoFactory::new()->create();
    $categoria = $producto->categoria;

    $this->delete(route('productos.destroy', $producto))->assertRedirect(route('productos.index'))->assertSessionHas('success');

    $this->assertModelMissing($producto);
    $this->assertModelExists($categoria);
});

test('responde con 404 para un producto inexistente', function () {
    $this->get(route('productos.show', 999999))->assertNotFound();
    $this->get(route('productos.edit', 999999))->assertNotFound();
    $this->delete(route('productos.destroy', 999999))->assertNotFound();
});

test('pagina el listado de productos', function () {
    ProductoFactory::new()->count(11)->create();

    $this->get(route('productos.index'))->assertOk()->assertViewHas('productos', fn ($productos) => $productos->count() === 10 && $productos->total() === 11);
    $this->get(route('productos.index', ['page' => 2]))->assertOk()->assertViewHas('productos', fn ($productos) => $productos->count() === 1);
});
