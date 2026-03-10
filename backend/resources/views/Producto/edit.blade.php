<h1>Editar Producto</h1>

<form action="/productos/{{ $producto->id }}" method="POST">

@csrf
@method('PUT')

<label>Nombre</label>
<input type="text" name="nombre" value="{{ $producto->nombre }}">

<br><br>

<label>Descripcion</label>
<input type="text" name="descripcion" value="{{ $producto->descripcion }}">

<br><br>

<label>Precio</label>
<input type="number" name="precio" value="{{ $producto->precio }}">

<br><br>

<label>Stock</label>
<input type="number" name="stock" value="{{ $producto->stock }}">

<br><br>

<button type="submit">Actualizar</button>

</form>