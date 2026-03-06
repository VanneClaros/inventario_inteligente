<h1>Lista de Productos</h1>

<a href="/productos/create">Nuevo Producto</a>

<table border="1">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Descripción</th>
<th>Precio</th>
<th>Stock</th>
</tr>

@foreach

($productos as $producto)  
<td>{{ $producto->id }}</td>
<td>{{ $producto->nombre }}</td>
<td>{{ $producto->descripcion }}</td>
<td>{{ $producto->precio }}</td>
<td>{{ $producto->stock }}</td>
</tr>

@endforeach
</table>